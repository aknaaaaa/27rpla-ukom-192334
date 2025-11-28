<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Fasilitas;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::with('fasilitas')->orderBy('name')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return redirect()->route('admin.kategori.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        Kategori::create($validated);

        return redirect()->route('admin.kategori.index')->with('ok', 'Kategori berhasil dibuat.');
    }

    public function edit($id)
    {
        return redirect()->route('admin.kategori.index')->with('edit_id', $id);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')->with('ok', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Hapus semua fasilitas yang terkait
        Fasilitas::where('id_kategori', $id)->delete();
        
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('ok', 'Kategori dan fasilitas terkait berhasil dihapus.');
    }

    /**
     * Get fasilitas by kategori (untuk AJAX)
     */
    public function getFasilitas($id)
    {
        $fasilitas = Fasilitas::where('id_kategori', $id)
            ->whereNull('id_kamar')
            ->get(['id_fasilitas', 'nama_fasilitas', 'deskripsi']);
        
        return response()->json($fasilitas);
    }

    /**
     * Store fasilitas untuk kategori
     */
    public function storeFasilitas(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:categories,id',
            'nama_fasilitas' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        Fasilitas::create($validated);

        return redirect()->route('admin.kategori.index')->with('ok', 'Fasilitas berhasil ditambahkan.');
    }

    /**
     * Delete fasilitas
     */
    public function deleteFasilitas($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        
        $fasilitas->delete();

        return redirect()->route('admin.kategori.index')->with('ok', 'Fasilitas berhasil dihapus.');
    }
}
