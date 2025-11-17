<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayoutsController extends Controller
{
    public function index()
    {
        // Panggil view index yang ada di resources/views/layouts/index.blade.php
        return view('layouts.index');
    }
    public function daftar()
    {
        return view('auth.register');
    }
    public function masuk(){
        return view('auth.login');
    }
    public function profile(){
        $user = Auth::user();

        return view('profile.profile', [
            'user' => $user,
        ]);
    }

    public function adminDashboard()
    {
        $metrics = [
            'total_orders' => 12,
            'occupied_rooms' => 136,
            'available_rooms' => 24,
            'total_revenue' => 'Rp 0',
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
