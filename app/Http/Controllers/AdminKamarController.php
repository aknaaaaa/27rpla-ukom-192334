<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Kategori;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminKamarController extends Controller
{
    public function index()
    {
        $rooms = Kamar::with('kategoriRelasi', 'fasilitas')->latest()->get();
        $kategoris = Kategori::orderBy('name')->get();

        return view('admin.rooms.index', compact('rooms', 'kategoris'));
    }

    public function getFasilitas($kategoriId, Request $request)
    {
        $roomId = $request->query('room_id');

        $fasilitas = Fasilitas::where('id_kategori', $kategoriId)
            ->when($roomId, function ($query) use ($roomId) {
                $query->where(function ($sub) use ($roomId) {
                    $sub->whereNull('id_kamar')
                        ->orWhere('id_kamar', $roomId);
                });
            }, function ($query) {
                $query->whereNull('id_kamar');
            })
            ->orderBy('nama_fasilitas')
            ->get(['id_fasilitas', 'nama_fasilitas', 'deskripsi', 'id_kamar']);
        
        return response()->json($fasilitas);
    }

    public function edit($id)
    {
        return redirect()->route('admin.rooms.index')->with('edit_id', $id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:100|unique:kamars,nama_kamar',
            'id_kategori' => 'required|exists:categories,id',
            'harga_permalam' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kapasitas' => 'required|integer|min:1|max:10',
            'ukuran_kamar' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'status_kamar' => 'nullable|in:Tersedia,Penuh,Maintenance,Telah di reservasi',
            'image' => 'required|image|max:4096|mimes:jpg,jpeg,png,webp',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id_fasilitas',
        ], [
            'nama_kamar.unique' => 'Nama kamar sudah digunakan.',
            'nama_kamar.required' => 'Nama kamar wajib diisi.',
            'kapasitas.required' => 'Kapasitas kamar wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
        ]);

        $upload = Cloudinary::uploadApi()->upload(
            $request->file('image')->getRealPath(),
            ['folder' => env('CLOUDINARY_UPLOAD_FOLDER', 'hotel_d-kasuari')]
        );
        $imageUrl = $upload['secure_url'];

        $kategori = Kategori::findOrFail($validated['id_kategori']);
        $status = $validated['status_kamar'] ?? 'Tersedia';
        if (($validated['stok'] ?? 0) <= 0 && strtolower($status) !== 'maintenance') {
            $status = 'Penuh';
        } elseif (($validated['stok'] ?? 0) > 0 && strtolower($status) === 'penuh') {
            $status = 'Tersedia';
        }

        $kamar = Kamar::create([
            'nama_kamar' => $validated['nama_kamar'],
            'kategori' => $validated['kategori'],
            'harga_permalam' => $validated['harga_permalam'],
            'stok' => $validated['stok'],
            'kapasitas' => $validated['kapasitas'],
            'ukuran_kamar' => $validated['ukuran_kamar'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status_kamar' => $status,
            'gambar' => $imageUrl,
        ]);

        // Assign fasilitas ke kamar jika dipilih
        if (!empty($validated['fasilitas'])) {
            Fasilitas::whereIn('id_fasilitas', $validated['fasilitas'])
                ->update(['id_kamar' => $kamar->id_kamar]);
        }

        return redirect()->route('admin.rooms.index')->with('ok', 'Kamar baru berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $room = Kamar::findOrFail($id);

        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:100|unique:kamars,nama_kamar,' . $id . ',id_kamar',
            'id_kategori' => 'required|exists:categories,id',
            'harga_permalam' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kapasitas' => 'required|integer|min:1|max:10',
            'ukuran_kamar' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'status_kamar' => 'nullable|in:Tersedia,Penuh,Maintenance,Telah di reservasi',
            'image' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,webp',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id_fasilitas',
        ], [
            'nama_kamar.unique' => 'Nama kamar sudah digunakan.',
            'nama_kamar.required' => 'Nama kamar wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'kapasitas.required' => 'Kapasitas kamar wajib diisi.',
        ]);

        $imageUrl = $room->gambar;

        if ($request->hasFile('image')) {
            $upload = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => env('CLOUDINARY_UPLOAD_FOLDER', 'hotel_d-kasuari')]
            );
            $imageUrl = $upload['secure_url'];
        }

        $kategori = Kategori::findOrFail($validated['id_kategori']);
        $status = $validated['status_kamar'] ?? $room->status_kamar;
        $stokBaru = $validated['stok'] ?? $room->stok;
        if ($stokBaru <= 0 && strtolower($status) !== 'maintenance') {
            $status = 'Penuh';
        } elseif ($stokBaru > 0 && strtolower($status) === 'penuh') {
            $status = 'Tersedia';
        }

        $room->update([
            'nama_kamar' => $validated['nama_kamar'],
            'kategori' => $validated['kategori'],
            'harga_permalam' => $validated['harga_permalam'],
            'stok' => $stokBaru,
            'kapasitas' => $validated['kapasitas'],
            'ukuran_kamar' => $validated['ukuran_kamar'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status_kamar' => $status,
            'gambar' => $imageUrl,
        ]);

        // Update fasilitas
        // First, remove all current fasilitas for this room
        Fasilitas::where('id_kamar', $room->id_kamar)->update(['id_kamar' => null]);

        // Then assign new fasilitas jika dipilih
        if (!empty($validated['fasilitas'])) {
            Fasilitas::whereIn('id_fasilitas', $validated['fasilitas'])
                ->update(['id_kamar' => $room->id_kamar]);
        }

        return redirect()->route('admin.rooms.index')->with('ok', 'Kamar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $room = Kamar::findOrFail($id);
        
        // Remove fasilitas association
        Fasilitas::where('id_kamar', $room->id_kamar)->update(['id_kamar' => null]);
        
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('ok', 'Kamar berhasil dihapus.');
    }
}
