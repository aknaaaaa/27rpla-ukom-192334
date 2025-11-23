<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class AdminPemesananController extends Controller
{
    public function index(Request $request)
    {
        $orders = Pemesanan::with(['user', 'kamar', 'pembayaran'])
            ->latest()
            ->get();

        $metrics = [
            'total' => $orders->count(),
            'occupied' => $orders->filter(fn ($o) => $o->status_label === 'Occupying')->count(),
            'pending' => $orders->filter(fn ($o) => $o->status_label === 'Pending')->count(),
            'canceled' => $orders->filter(fn ($o) => $o->status_label === 'Canceled')->count(),
        ];

        return view('admin.orders', compact('orders', 'metrics'));
    }
}
