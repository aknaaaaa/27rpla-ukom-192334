<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\CoreApi;

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
            'items.*.id' => 'nullable|string|max:50',
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

        $baseParams = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $items->toArray(),
            'customer_details' => [
                'first_name' => data_get($request->customer, 'first_name'),
                'email' => data_get($request->customer, 'email'),
                'phone' => data_get($request->customer, 'phone'),
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

            // Simpan ke tabel pembayarans jika id_pemesanan disertakan
            if ($request->filled('id_pemesanan')) {
                $status = match ($response->transaction_status ?? 'pending') {
                    'capture', 'settlement' => 'Telah dibayar',
                    'cancel', 'deny', 'expire' => 'Dibatalkan',
                    default => 'Belum dibayar',
                };

                Pembayaran::create([
                    'id_pemesanan' => $request->id_pemesanan,
                    'payment_method' => strtoupper($request->payment_method),
                    'payment_date' => Carbon::today(),
                    'amount_paid' => $grossAmount,
                    'status_pembayaran' => $status,
                ]);
            }

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
}
