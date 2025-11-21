<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        $verify = config('midtrans.verify_ssl', true);
        Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => (bool) $verify,
            CURLOPT_SSL_VERIFYHOST => $verify ? 2 : 0,
        ];
        if (!isset(Config::$curlOptions[CURLOPT_HTTPHEADER])) {
            Config::$curlOptions[CURLOPT_HTTPHEADER] = [];
        }
    }

    private function mapPaymentStatus(string $statusRaw, ?string $fraudStatus = null): string
    {
        return match ($statusRaw) {
            'capture', 'settlement', 'success' => $fraudStatus === 'challenge' ? 'Belum dibayar' : 'Telah dibayar',
            'cancel', 'deny', 'expire', 'refund', 'chargeback', 'partial_refund' => 'Dibatalkan',
            default => 'Belum dibayar',
        };
    }

    private function extractPemesananIdFromOrder(?string $orderId): ?string
    {
        if (!$orderId || !str_starts_with($orderId, 'PMS-')) {
            return null;
        }

        $parts = explode('-', $orderId);
        return $parts[1] ?? null;
    }

    private function storePaymentIfAny(?string $pemesananId, string $method, float $amount, string $status): void
    {
        if (!$pemesananId) {
            return;
        }

        Pembayaran::updateOrCreate(
            ['id_pemesanan' => $pemesananId],
            [
                'payment_method' => strtoupper($method),
                'payment_date' => Carbon::today(),
                'amount_paid' => $amount,
                'status_pembayaran' => $status,
            ]
        );
    }

    private function rememberLastPayment(string $orderId, ?string $pemesananId, string $statusRaw, string $statusNormalized): void
    {
        session([
            'last_payment' => [
                'status' => $statusNormalized === 'Telah dibayar' ? 'success' : $statusRaw,
                'order' => $orderId,
                'id_pemesanan' => $pemesananId,
            ]
        ]);
    }

    public function createCharge(Request $request)
    {
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
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:bca,bni,gopay,ovo,dana,qris',
            'amount' => 'required|numeric|min:1000',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:150',
            'items.*.price' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.id' => 'nullable',
            'id_pemesanan' => 'nullable|exists:pemesanans,id_pemesanan',
            'customer.first_name' => 'nullable|string|max:80',
            'customer.email' => 'nullable|email',
            'customer.phone' => 'nullable|string|max:20',
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
        $bookingInfo = $request->input('booking', []);

        $items = collect($request->input('items', []))
            ->values()
            ->map(function ($item, $idx) {
                return [
                    'id' => data_get($item, 'id', 'ITEM-' . ($idx + 1)),
                    'name' => data_get($item, 'name', 'Item ' . ($idx + 1)),
                    'price' => (int) data_get($item, 'price', 0),
                    'quantity' => (int) data_get($item, 'quantity', 1),
                ];
            });

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
        $grossAmount = $items->sum(fn ($i) => $i['price'] * $i['quantity']);

        // buat pemesanan minimal jika belum ada id_pemesanan namun user login
        if (!$pemesananId && Auth::check()) {
            $firstItem = $items->first();
            $firstItemId = $firstItem['id'] ?? null;
            if (!$firstItemId) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => ['items' => ['ID kamar tidak ditemukan pada item.']],
                ], 422);
            }

            $checkInInput = data_get($bookingInfo, 'check_in');
            $checkOutInput = data_get($bookingInfo, 'check_out');
            $checkInDate = $checkInInput ? Carbon::parse($checkInInput) : Carbon::today();
            $checkOutDate = $checkOutInput ? Carbon::parse($checkOutInput) : $checkInDate->copy()->addDay();
            if ($checkOutDate->lessThanOrEqualTo($checkInDate)) {
                $checkOutDate = $checkInDate->copy()->addDay();
            }
            $totalDays = max(1, $checkInDate->diffInDays($checkOutDate));

            $pemesanan = Pemesanan::create([
                'id_user' => Auth::id(),
                'id_kamar' => $firstItemId,
                'booking_code' => 'BOOK-' . Str::upper(Str::random(6)),
                'check_in' => $checkInDate,
                'check_out' => $checkOutDate,
                'total_hari' => $totalDays,
            ]);
            $pemesananId = $pemesanan->id_pemesanan;
            $orderId = 'PMS-' . $pemesananId . '-' . Str::upper(Str::random(6));
        }

        $customerName = data_get($bookingInfo, 'name', data_get($request->customer, 'first_name'));
        $customerEmail = data_get($bookingInfo, 'email', data_get($request->customer, 'email'));
        $customerPhone = data_get($bookingInfo, 'phone', data_get($request->customer, 'phone'));

        $baseParams = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $items->toArray(),
            'customer_details' => [
                'first_name' => $customerName,
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
            return response()->json([
                'message' => 'Metode belum didukung.',
            ], 422);
        }

        try {
            $response = CoreApi::charge($params);

            $statusRaw = $response->transaction_status ?? 'pending';
            $fraud = $response->fraud_status ?? null;
            $status = $this->mapPaymentStatus($statusRaw, $fraud);

            // Simpan ke tabel pembayarans jika id_pemesanan disertakan
            $this->storePaymentIfAny($pemesananId, $request->payment_method, $grossAmount, $status);

            $this->rememberLastPayment($orderId, $pemesananId, $statusRaw, $status);

            // sisipkan url redirect agar front-end tahu tujuan success
            $response->app_order_id = $orderId;
            $response->id_pemesanan = $pemesananId;
            $response->redirect_url = route('checkout.success');

            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Midtrans charge failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'message' => 'Gagal membuat pembayaran',
                'error' => $e->getMessage(),
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

        $statusRaw = $payload['transaction_status'] ?? 'pending';
        $fraud = $payload['fraud_status'] ?? null;
        $status = $this->mapPaymentStatus($statusRaw, $fraud);

        // coba temukan id_pemesanan dari order_id yang disematkan
        $pemesananId = $this->extractPemesananIdFromOrder($orderId);

        $this->storePaymentIfAny(
            $pemesananId,
            $payload['payment_type'] ?? 'UNKNOWN',
            (float) $grossAmount,
            $status
        );

        return response()->json(['message' => 'ok']);
    }

    public function status(string $orderId)
    {
        if (!$orderId) {
            return response()->json(['message' => 'Order ID tidak ditemukan'], 422);
        }

        try {
            $midtransStatus = Transaction::status($orderId);
            $statusRaw = $midtransStatus->transaction_status ?? 'pending';
            $fraud = $midtransStatus->fraud_status ?? null;
            $status = $this->mapPaymentStatus($statusRaw, $fraud);

            $pemesananId = $this->extractPemesananIdFromOrder($orderId);
            $amount = (float) ($midtransStatus->gross_amount ?? 0);

            $this->storePaymentIfAny(
                $pemesananId,
                $midtransStatus->payment_type ?? 'UNKNOWN',
                $amount,
                $status
            );

            $this->rememberLastPayment($orderId, $pemesananId, $statusRaw, $status);

            return response()->json([
                'order_id' => $orderId,
                'transaction_status' => $statusRaw,
                'fraud_status' => $fraud,
                'status_pembayaran' => $status,
                'id_pemesanan' => $pemesananId,
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans status check failed', [
                'message' => $e->getMessage(),
                'order_id' => $orderId,
            ]);

            return response()->json([
                'message' => 'Gagal mengambil status pembayaran',
            ], 500);
        }
    }
}
