<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminKamarController extends Controller
{
    public function index()
    {
        $rooms = Kamar::latest()->get();

        return view('admin.rooms', [
            'rooms' => $rooms,
        ]);
    }

    public function edit($id)
    {
        // Edit sekarang dilakukan via modal di halaman daftar kamar
        return redirect()->route('admin.rooms')->with('edit_id', $id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kamar' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:100'],
            'harga_permalam' => ['required', 'numeric', 'min:0'],
            'ukuran_kamar' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'status_kamar' => ['nullable', 'in:Tersedia,Telah di reservasi,Maintenance'],
            'image' => ['required', 'image', 'max:4096', 'mimes:jpg,jpeg,png,webp'],
        ]);

        $imageUrl = $this->uploadRoomImage($request->file('image'));

        Kamar::create([
            'nama_kamar' => $validated['nama_kamar'],
            'kategori' => $validated['kategori'],
            'harga_permalam' => $validated['harga_permalam'],
            'ukuran_kamar' => $validated['ukuran_kamar'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status_kamar' => $validated['status_kamar'] ?? 'Tersedia',
            'gambar' => $imageUrl,
        ]);

        return redirect()->route('admin.rooms')->with('ok', 'Kamar baru berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $room = Kamar::findOrFail($id);

        $validated = $request->validate([
            'nama_kamar' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:100'],
            'harga_permalam' => ['required', 'numeric', 'min:0'],
            'ukuran_kamar' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'status_kamar' => ['nullable', 'in:Tersedia,Telah di reservasi,Maintenance'],
            'image' => ['nullable', 'image', 'max:4096', 'mimes:jpg,jpeg,png,webp'],
        ]);

        $imageUrl = $room->gambar;

        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadRoomImage($request->file('image')) ?: $room->gambar;
        }

        $room->update([
            'nama_kamar' => $validated['nama_kamar'],
            'kategori' => $validated['kategori'],
            'harga_permalam' => $validated['harga_permalam'],
            'ukuran_kamar' => $validated['ukuran_kamar'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status_kamar' => $validated['status_kamar'] ?? 'Tersedia',
            'gambar' => $imageUrl,
        ]);

        return redirect()->route('admin.rooms')->with('ok', 'Kamar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $room = Kamar::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.rooms')->with('ok', 'Kamar berhasil dihapus.');
    }

    /**
     * Upload gambar kamar ke Cloudinary, fallback ke storage lokal jika gagal.
     */
    private function uploadRoomImage($file): ?string
    {
        if (!$file) {
            return null;
        }

        // Simpan lokal dulu supaya tetap tampil meski Cloudinary tidak bisa diakses
        $localPath = $file->store('kamar', 'public');
        $localUrl = $localPath ? Storage::url($localPath) : null;

        try {
            $upload = Cloudinary::uploadApi()->upload(
                $file->getRealPath(),
                ['folder' => env('CLOUDINARY_UPLOAD_FOLDER', 'hotel_d-kasuari')]
            );
            if (!empty($upload['secure_url'])) {
                // simpan URL cloud di log untuk referensi, tapi pakai lokal agar pasti bisa di-load
                Log::info('Cloudinary upload success', ['url' => $upload['secure_url']]);
            }
        } catch (\Throwable $e) {
            Log::warning('Cloudinary upload gagal, fallback ke lokal', [
                'message' => $e->getMessage(),
            ]);
        }

        return $localUrl;
    }
}
