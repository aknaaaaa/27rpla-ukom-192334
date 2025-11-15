<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input tanggal dari form
        // ambil nilai checkin dan checkout dari form
        $checkIn = $request->input('checkin');
        $checkOut = $request->input('checkout');

        $query = Kamar::query();

        // filter kamar jika tanggal diisi
        if ($checkIn && $checkOut) {
            $query->whereDoesntHave('pemesanans', function ($q) use ($checkIn, $checkOut) {
                $q->where(function ($sub) use ($checkIn, $checkOut) {
                    // bentrok jika checkin < checkout dan checkout > checkin
                    $sub->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                });
            });
        }


        // Ambil semua kamar
        $query = Kamar::query();

        /*
        // 🔒 Logika filter tanggal — sementara dinonaktifkan
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
        */

        // Ambil semua kamar tanpa filter
        $kamars = $query->get();

        return view('kamar.index', compact('kamars', 'checkIn', 'checkOut'));
    }
}
