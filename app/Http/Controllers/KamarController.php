<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = [
            [
                'id' => 1,
                'nama' => 'Kamar Boedak',
                'harga' => 20000,
                'kapasitas' => 1,
                'ukuran' => '10 m²',
                'foto' => 'images/kamar1.jpg',
                'sisa' => 1,
            ]
        ];

        return view('kamar.index', compact('kamars'));
    }

    public function show($id)
    {
        $kamar = [
            'id' => 1,
            'nama' => 'Kamar Boedak',
            'harga' => 20000,
            'kapasitas' => 1,
            'ukuran' => '10 m²',
            'foto' => 'images/kamar1.jpg',
            'deskripsi' => 'Kamar sederhana untuk kamu yang butuh tempat rebahan tanpa ribet...',
            'fasilitas' => [
                'Area parkir tersedia',
                'Kipas angin / ventilasi alami',
                'Single bed nyaman',
                'Colokan listrik pribadi',
                'Penerangan hemat energi',
                'Perlengkapan dasar (handuk & sabun mini)',
            ]
        ];

        return view('kamar.detail', compact('kamar'));
    }
}
