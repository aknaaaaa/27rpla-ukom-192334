<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayoutsController extends Controller
{
    public function index()
    {
        // Panggil view index yang ada di resources/views/layouts/index.blade.php
        $discoverRooms = Kamar::latest()->take(5)->get();
        $sekilasRooms = Kamar::latest()->take(3)->get();

        return view('layouts.index', compact('discoverRooms', 'sekilasRooms'));
    }
    public function daftar()
    {
        return view('layouts.register');
    }
    public function masuk(){
        return view('layouts.login');
    }
    public function profile(Request $request){
        $user = Auth::user();
        $tab = $request->query('tab', 'profile');
        $orders = Pemesanan::with(['kamar', 'pembayaran'])
            ->where('id_user', $user?->id_user)
            ->latest()
            ->limit(3)
            ->get();
        $history = Pemesanan::with(['kamar', 'pembayaran'])
            ->where('id_user', $user?->id_user)
            ->latest()
            ->skip(3)
            ->take(10)
            ->get();
        $allOrders = Pemesanan::with(['kamar', 'pembayaran'])
            ->where('id_user', $user?->id_user)
            ->latest()
            ->get();

        return view('profile.profile', [
            'user' => $user,
            'orders' => $orders,
            'history' => $history,
            'allOrders' => $allOrders,
            'tab' => $tab,
        ]);
    }

    public function checkout()
    {
        $user = Auth::user();

        return view('kamar.checkout', [
            'user' => $user,
        ]);
    }

    public function adminDashboard()
    {
        $totalOrders = Pemesanan::count();
        $occupiedRooms = Kamar::where('status_kamar', 'Telah di reservasi')->count();
        $availableRooms = Kamar::where('status_kamar', 'Tersedia')->count();
        $maintenanceRooms = Kamar::where('status_kamar', 'Maintenance')->count();
        $totalRevenue = Pembayaran::where('status_pembayaran', 'Telah dibayar')->sum('amount_paid');

        $metrics = [
            'total_orders' => $totalOrders,
            'occupied_rooms' => $occupiedRooms,
            'available_rooms' => $availableRooms,
            'maintenance_rooms' => $maintenanceRooms,
            'total_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
        ];

        return view('admin.dashboard', [
            'metrics' => $metrics,
        ]);
    }

    public function adminRooms()
    {
        $rooms = [
            [
                'name' => 'Kamar Boedak',
                'category' => '1 Orang',
                'size' => '10 m2',
                'type' => 'Single',
                'breakfast' => 'Sarapan tidak tersedia',
                'policy' => 'Tidak bisa refund & reschedule',
                'occupied' => 10,
                'vacant' => 14,
                'count' => 24,
                'price' => 'Rp20.000 / Malam',
                'image' => asset('images/discover%20(1).jpg'),
            ],
            [
                'name' => 'Kamar Boedak',
                'category' => '1 Orang',
                'size' => '10 m2',
                'type' => 'Single',
                'breakfast' => 'Sarapan tidak tersedia',
                'policy' => 'Tidak bisa refund & reschedule',
                'occupied' => 10,
                'vacant' => 14,
                'count' => 24,
                'price' => 'Rp20.000 / Malam',
                'image' => asset('images/discover%20(2).jpg'),
            ],
        ];

        return view('admin.rooms', [
            'rooms' => $rooms,
        ]);
    }
}
