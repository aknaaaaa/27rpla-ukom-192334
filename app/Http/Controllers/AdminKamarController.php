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

        return view('admin.rooms.index', compact('rooms'));
    }

    public function edit($id)
    {
        // Edit lewat modal
        return redirect()->route('admin.rooms.index')->with('edit_id', $id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:100|unique:kamars,nama_kamar',
            'kategori' => 'required|string|max:50',
            'harga_permalam' => 'required|numeric|min:0',
            'ukuran_kamar' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok_kamar' => 'required|integer|min:0',
            'status_kamar' => 'nullable|in:Tersedia,Penuh,Maintenance',
            'image' => 'required|image|max:4096|mimes:jpg,jpeg,png,webp',
        ]);

        // Upload Gambar
        $upload = Cloudinary::uploadApi()->upload(
            $request->file('image')->getRealPath(),
            ['folder' => env('CLOUDINARY_UPLOAD_FOLDER', 'hotel_d-kasuari')]
        );
        $imageUrl = $upload['secure_url'];

        // Jika stok habis → status otomatis penuh
        $status = $validated['stok_kamar'] == 0 ? 'Penuh' : ($validated['status_kamar'] ?? 'Tersedia');

        Kamar::create([
            'nama_kamar' => $validated['nama_kamar'],
            'kategori' => $validated['kategori'],
            'harga_permalam' => $validated['harga_permalam'],
            'ukuran_kamar' => $validated['ukuran_kamar'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'stok_kamar' => $validated['stok_kamar'],
            'status_kamar' => $status,
            'gambar' => $imageUrl,
        ]);

        return redirect()->route('admin.rooms.index')->with('ok', 'Kamar baru berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $room = Kamar::findOrFail($id);

        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:100|unique:kamars,nama_kamar,' . $id . ',id_kamar',
            'kategori' => 'required|string|max:50',
            'harga_permalam' => 'required|numeric|min:0',
            'ukuran_kamar' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok_kamar' => 'required|integer|min:0',
            'status_kamar' => 'nullable|in:Tersedia,Penuh,Maintenance',
            'image' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,webp',
        ]);

        $imageUrl = $room->gambar;

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            $upload = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => env('CLOUDINARY_UPLOAD_FOLDER', 'hotel_d-kasuari')]
            );
            $imageUrl = $upload['secure_url'];
        }

        // Aturan stok → status
        $status = $validated['stok_kamar'] == 0
            ? 'Penuh'
            : ($validated['status_kamar'] ?? $room->status_kamar);

        $room->update([
            'nama_kamar' => $validated['nama_kamar'],
            'kategori' => $validated['kategori'],
            'harga_permalam' => $validated['harga_permalam'],
            'ukuran_kamar' => $validated['ukuran_kamar'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'stok_kamar' => $validated['stok_kamar'],
            'status_kamar' => $status,
            'gambar' => $imageUrl,
        ]);

        return redirect()->route('admin.rooms.index')->with('ok', 'Kamar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $room = Kamar::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('ok', 'Kamar berhasil dihapus.');
    }
}
