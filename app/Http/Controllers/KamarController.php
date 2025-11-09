<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        // Data kamar dalam bentuk array
        $kamars = [
            [
                'id' => 1,
                'nama' => 'Kamar Boedak',
                'harga' => 20000,
                'kapasitas' => 1,
                'luas' => 10, // ganti dari 'ukuran' ke 'luas' agar sesuai tampilan
                'gambar' => 'kamar1.jpg', // ganti dari 'foto' agar nama konsisten dengan view
                'sisa' => 1,
                'deskripsi' => 'Kamar sederhana untuk kamu yang butuh tempat rebahan tanpa ribet.',
            ],
        ];

        // Kirim data ke view
        return view('kamar.index', compact('kamars'));
    }

    public function show($id)
    {
        // Detail 1 kamar (dapat dikembangkan jadi dinamis nanti)
        $kamar = [
            'id' => 1,
            'nama' => 'Kamar Boedak',
            'harga' => 20000,
            'kapasitas' => 1,
            'luas' => 10,
            'gambar' => 'kamar1.jpg',
            'deskripsi' => 'Kamar sederhana untuk kamu yang butuh tempat rebahan tanpa ribet...',
            'fasilitas' => [
                'Area parkir tersedia',
                'Kipas angin / ventilasi alami',
                'Single bed nyaman',
                'Colokan listrik pribadi',
                'Penerangan hemat energi',
                'Perlengkapan dasar (handuk & sabun mini)',
            ],
        ];

        return view('kamar.detail', compact('kamar'));
    }
}
