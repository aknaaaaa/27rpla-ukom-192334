<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        // Ambil semua kamar
        $query = Kamar::query();

        if ($checkIn && $checkOut) {
            // Filter kamar yang tidak memiliki pemesanan bentrok
            $query->whereDoesntHave('pemesanans', function ($q) use ($checkIn, $checkOut) {
                $q->where(function ($sub) use ($checkIn, $checkOut) {
                    $sub->where(function ($w) use ($checkIn, $checkOut) {
                        $w->where('check_in', '<', $checkOut)
                          ->where('check_out', '>', $checkIn);
                    });
                });
            });
        }

        $kamars = $query->get();

        return view('kamar.index', compact('kamars', 'checkIn', 'checkOut'));
    }
}

