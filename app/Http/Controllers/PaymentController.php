<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Kamar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    // HAPUS __construct() atau kosongkan
    public function __construct()
    {
        // Kosongkan atau hapus
    }

    // TAMBAHKAN method ini
    private function initializeMidtrans()
    {
        if (!Config::$serverKey) {
            Config::$serverKey = config('midtrans.server_key');
            Config::$clientKey = config('midtrans.client_key');
            Config::$isProduction = (bool) config('midtrans.is_production', false);
            Config::$isSanitized = (bool) config('midtrans.is_sanitized', true);
            Config::$is3ds = (bool) config('midtrans.is_3ds', true);
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
            ];
        }
    }

    private function ensureMidtransConfigured()
    {
        // Panggil init dulu
        $this->initializeMidtrans();
        
        if (!Config::$serverKey) {
            return response()->json([
                'message' => 'Konfigurasi Midtrans belum lengkap. Isi MIDTRANS_SERVER_KEY (dan CLIENT_KEY) di .env lalu jalankan php artisan config:clear.',
                'developer_hint' => 'Midtrans server key kosong; cek config/midtrans.php dan .env.',
            ], 500);
        }
        if (str_contains(Config::$serverKey, 'Mid-client')) {
            return response()->json([
                'message' => 'Server key Midtrans salah. Gunakan server key (diawali SB-Mid-server-...), bukan client key.',
                'developer_hint' => 'Server key mengandung "Mid-client". Tukar nilai MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY di .env',
            ], 500);
        }
        if (Config::$isProduction && str_starts_with(Config::$serverKey, 'SB-')) {
            return response()->json([
                'message' => 'Server key sandbox terdeteksi, tetapi mode produksi aktif. Set MIDTRANS_IS_PRODUCTION=false untuk sandbox.',
                'developer_hint' => 'Sandbox key tidak boleh dipakai saat is_production=true',
            ], 500);
        }
        return null;
    }

    private function normalizePaymentStatus(?string $statusRaw, ?string $fraud = null): string
    {
        $statusRaw = strtolower($statusRaw ?? 'pending');

        return match ($statusRaw) {
            'capture', 'settlement', 'success' => $fraud === 'challenge' ? 'Belum dibayar' : 'Telah dibayar',
            'cancel', 'deny', 'expire', 'refund', 'chargeback', 'partial_refund' => 'Dibatalkan',
            default => 'Belum dibayar',
        };
    }

    public function createCharge(Request $request)
    {
        $this->initializeMidtrans(); // Panggil di setiap method
        
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return response()->json($snapToken);
    }

    public function charge(Request $request)
    {
        if ($resp = $this->ensureMidtransConfigured()) {
            return $resp;
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:bca,bni,gopay,ovo,dana,qris',
            'amount' => 'required|numeric|min:1000',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:150',
            'items.*.price' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.room_units' => 'nullable|integer|min:1',
            'items.*.id' => 'nullable',
            'id_pemesanan' => 'nullable|exists:pemesanans,id',
            'customer.first_name' => 'nullable|string|max:80',
            'customer.email' => 'nullable|email',
            'customer.phone' => 'nullable|string|max:20',
            'booking.name' => 'nullable|string|max:120',
            'booking.email' => 'nullable|email',
            'booking.phone' => 'nullable|string|max:30',
            'booking.check_in' => 'nullable|date',
            'booking.check_out' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $method = $request->payment_method;
        if (in_array($method, ['ovo', 'dana'])) {
            return response()->json([
                'message' => 'Metode OVO/DANA belum diaktifkan via Core API. Gunakan QRIS atau GoPay untuk e-wallet.',
            ], 422);
        }

        $orderId = 'HOTEL-' . Str::uuid();
        $amount = (int) $request->amount;
        $pemesananId = $request->id_pemesanan;

        $checkinStr = data_get($request->booking, 'check_in', $request->input('checkin_date'));
        $checkoutStr = data_get($request->booking, 'check_out', $request->input('checkout_date'));
        $checkinDate = $checkinStr ? Carbon::parse($checkinStr) : Carbon::today();
        $checkoutDate = $checkoutStr ? Carbon::parse($checkoutStr) : Carbon::today()->addDay();
        if ($checkoutDate->lessThanOrEqualTo($checkinDate)) {
            $checkoutDate = (clone $checkinDate)->addDay();
        }
        $totalNights = max(1, $checkinDate->diffInDays($checkoutDate));

        $items = collect($request->input('items', []))
            ->values()
            ->map(function ($item, $idx) {
                return [
                    'id' => data_get($item, 'id', 'ITEM-' . ($idx + 1)),
                    'name' => data_get($item, 'name', 'Item ' . ($idx + 1)),
                    'price' => (int) data_get($item, 'price', 0),
                    'quantity' => (int) data_get($item, 'quantity', 1),
                    'room_units' => (int) data_get($item, 'room_units', 0),
                ];
            });

        $roomOrders = $items->filter(fn ($i) => !empty($i['id']) && ($i['room_units'] ?? 0) > 0);
        if ($roomOrders->isEmpty()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => ['items' => ['Tidak ada kamar yang dikirim untuk dipesan.']],
            ], 422);
        }

        $subtotal = $items->sum(fn ($i) => $i['price'] * $i['quantity']);
        $tax = max(0, $amount - $subtotal);
        if ($tax > 0) {
            $items->push([
                'id' => 'TAX',
                'name' => 'Tax & Service',
                'price' => $tax,
                'quantity' => 1,
            ]);
        }
        $itemsForMidtrans = $items->map(function ($item) {
            return collect($item)->except('room_units')->toArray();
        });
        $grossAmount = $items->sum(fn ($i) => $i['price'] * $i['quantity']);
        $customerFirstName = data_get($request->customer, 'first_name', data_get($request->booking, 'name'));
        $customerEmail = data_get($request->customer, 'email', data_get($request->booking, 'email'));
        $customerPhone = data_get($request->customer, 'phone', data_get($request->booking, 'phone'));

        try {
            DB::beginTransaction();

            foreach ($roomOrders as $roomOrder) {
                $roomId = $roomOrder['id'];
                $roomsRequested = (int) $roomOrder['room_units'];

                /** @var Kamar|null $room */
                $room = Kamar::lockForUpdate()->find($roomId);
                if (!$room) {
                    throw ValidationException::withMessages([
                        'items' => ["Kamar dengan ID {$roomId} tidak ditemukan."],
                    ]);
                }

                if ($roomsRequested > $room->stok) {
                    throw ValidationException::withMessages([
                        'items' => ["Stok {$room->nama_kamar} hanya {$room->stok}. Kurangi jumlah atau pilih kamar lain."],
                    ]);
                }

                $room->stok -= $roomsRequested;
                $statusLower = strtolower($room->status_kamar ?? '');
                if ($room->stok <= 0 && $statusLower !== 'maintenance') {
                    $room->status_kamar = 'Penuh';
                } elseif ($room->stok > 0 && $statusLower === 'penuh') {
                    $room->status_kamar = 'Tersedia';
                }
                $room->save();
            }

            if ($pemesananId) {
                $pemesanan = Pemesanan::lockForUpdate()->findOrFail($pemesananId);
                $pemesanan->fill([
                    'id_kamar' => $pemesanan->id_kamar ?? $roomOrders->first()['id'],
                    'tanggal_checkin' => $checkinDate,
                    'tanggal_checkout' => $checkoutDate,
                    'check_in' => $checkinDate,
                    'check_out' => $checkoutDate,
                    'total_hari' => $totalNights,
                    'nama_penginap' => $customerFirstName,
                    'email_penginap' => $customerEmail,
                    'telepon_penginap' => $customerPhone,
                    'total_harga' => $grossAmount,
                    'status' => $pemesanan->status ?? 'Menunggu Pembayaran',
                ]);
                $pemesanan->save();
                $orderId = 'PMS-' . $pemesanan->id . '-' . Str::upper(Str::random(6));
            } elseif (Auth::check()) {
                $firstItem = $roomOrders->first();
                $firstItemId = $firstItem['id'] ?? null;
                $pemesanan = Pemesanan::create([
                    'id_user' => Auth::id(),
                    'id_kamar' => $firstItemId,
                    'kode_pesanan' => 'BOOK-' . Str::upper(Str::random(6)),
                    'booking_code' => 'BOOK-' . Str::upper(Str::random(6)),
                    'tanggal_checkin' => $checkinDate,
                    'tanggal_checkout' => $checkoutDate,
                    'check_in' => $checkinDate,
                    'check_out' => $checkoutDate,
                    'total_hari' => $totalNights,
                    'tanggal_pemesanan' => Carbon::now(),
                    'status' => 'Menunggu Pembayaran',
                    'nama_penginap' => $customerFirstName,
                    'email_penginap' => $customerEmail,
                    'telepon_penginap' => $customerPhone,
                    'total_harga' => $grossAmount,
                ]);
                $pemesananId = $pemesanan->id;
                $orderId = 'PMS-' . $pemesananId . '-' . Str::upper(Str::random(6));
            }

            $baseParams = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grossAmount,
                ],
                'item_details' => $itemsForMidtrans->toArray(),
                'customer_details' => [
                    'first_name' => $customerFirstName,
                    'email' => $customerEmail,
                    'phone' => $customerPhone,
                ],
            ];

            switch ($method) {
                case 'bca':
                case 'bni':
                    $params = array_merge($baseParams, [
                        'payment_type' => 'bank_transfer',
                        'bank_transfer' => [
                            'bank' => $method,
                        ],
                    ]);
                    break;
                case 'gopay':
                    $params = array_merge($baseParams, [
                        'payment_type' => 'gopay',
                        'gopay' => [
                            'enable_callback' => true,
                            'callback_url' => url('/'),
                        ],
                    ]);
                    break;
                case 'qris':
                    $params = array_merge($baseParams, [
                        'payment_type' => 'qris',
                    ]);
                    break;
                default:
                    throw ValidationException::withMessages([
                        'payment_method' => ['Metode belum didukung.'],
                    ]);
            }

            $response = CoreApi::charge($params);

            if ($pemesananId) {
                $status = $this->normalizePaymentStatus($response->transaction_status ?? null, $response->fraud_status ?? null);

                Pembayaran::updateOrCreate(
                    ['id_pemesanan' => $pemesananId],
                    [
                        'payment_method' => strtoupper($request->payment_method),
                        'payment_date' => Carbon::today(),
                        'amount_paid' => $grossAmount,
                        'status_pembayaran' => $status,
                    ]
                );

                session(['last_pemesanan' => ['id' => $pemesananId]]);
            }

            DB::commit();

            return response()->json($response);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            $msg = $e->getMessage();
            \Log::error('Midtrans charge failed', [
                'message' => $msg,
                'trace' => $e->getTraceAsString(),
            ]);

            $isUnknownMerchant = str_contains(strtolower($msg), 'unknown merchant');
            $hint = $isUnknownMerchant
                ? 'Periksa MIDTRANS_SERVER_KEY (harus SB-Mid-server-...) dan MIDTRANS_IS_PRODUCTION=false untuk sandbox.'
                : 'Cek kredensial Midtrans atau payload.';

            return response()->json([
                'message' => 'Gagal membuat pembayaran',
                'error' => $msg,
                'developer_hint' => $hint,
            ], 500);
        }
    }

    public function notify(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signature = $payload['signature_key'] ?? '';

        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if (!$orderId || !$signature || $signature !== $expectedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $status = $this->normalizePaymentStatus(
            $payload['transaction_status'] ?? 'pending',
            $payload['fraud_status'] ?? null
        );

        // coba temukan id_pemesanan dari order_id yang disematkan
        $pemesananId = null;
        if (str_starts_with($orderId, 'PMS-')) {
            $parts = explode('-', $orderId);
            $pemesananId = $parts[1] ?? null;
        }

        if ($pemesananId) {
            Pembayaran::updateOrCreate(
                ['id_pemesanan' => $pemesananId],
                [
                    'payment_method' => strtoupper($payload['payment_type'] ?? 'UNKNOWN'),
                    'payment_date' => Carbon::today(),
                    'amount_paid' => (float) $grossAmount,
                    'status_pembayaran' => $status,
                ]
            );
        }

        return response()->json(['message' => 'ok']);
    }

    public function status(string $orderId)
    {
        if ($resp = $this->ensureMidtransConfigured()) {
            return $resp;
        }

        try {
            $response = Transaction::status($orderId);
            $statusText = $this->normalizePaymentStatus(
                $response->transaction_status ?? 'pending',
                $response->fraud_status ?? null
            );

            return response()->json([
                'order_id' => $orderId,
                'transaction_status' => $response->transaction_status ?? 'pending',
                'fraud_status' => $response->fraud_status ?? null,
                'status_pembayaran' => $statusText,
                'payment_type' => $response->payment_type ?? null,
                'va_numbers' => $response->va_numbers ?? [],
                'actions' => $response->actions ?? [],
                'gross_amount' => $response->gross_amount ?? null,
                'transaction_time' => $response->transaction_time ?? null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans status check failed', [
                'message' => $e->getMessage(),
                'order_id' => $orderId,
            ]);

            // Fallback: coba ambil status lokal jika order_id mengandung id pemesanan
            $pemesananId = null;
            if (str_starts_with($orderId, 'PMS-')) {
                $parts = explode('-', $orderId);
                $pemesananId = $parts[1] ?? null;
            }

            if ($pemesananId) {
                $payment = Pembayaran::where('id_pemesanan', $pemesananId)->first();
                if ($payment) {
                    return response()->json([
                        'order_id' => $orderId,
                        'status_pembayaran' => $payment->status_pembayaran,
                        'payment_method' => $payment->payment_method,
                        'amount_paid' => $payment->amount_paid,
                    ]);
                }
            }

            return response()->json([
                'message' => 'Gagal mengecek status pembayaran',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
