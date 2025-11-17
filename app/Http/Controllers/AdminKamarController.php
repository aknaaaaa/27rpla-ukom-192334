<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminKamarController extends Controller
{
    public function index()
    {
        $rooms = Kamar::latest()->get();

        return view('admin.rooms', [
            'rooms' => $rooms,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kamar' => ['required', 'string', 'max:100'],
            'harga_permalam' => ['required', 'numeric', 'min:0'],
            'ukuran_kamar' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'status_kamar' => ['nullable', 'in:Tersedia,Telah di reservasi,Maintenance'],
            'image' => ['required', 'image', 'max:4096', 'mimes:jpg,jpeg,png,webp'],
        ]);

        $upload = Cloudinary::uploadApi()->upload(
            $request->file('image')->getRealPath(),
            ['folder' => env('CLOUDINARY_UPLOAD_FOLDER', 'hotel_d-kasuari')]
        );

        $imageUrl = $upload['secure_url'] ?? null;

        Kamar::create([
            'nama_kamar' => $validated['nama_kamar'],
            'harga_permalam' => $validated['harga_permalam'],
            'ukuran_kamar' => $validated['ukuran_kamar'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status_kamar' => $validated['status_kamar'] ?? 'Tersedia',
            'gambar' => $imageUrl,
        ]);

        return redirect()->route('admin.rooms')->with('ok', 'Kamar baru berhasil dibuat.');
    }
}
