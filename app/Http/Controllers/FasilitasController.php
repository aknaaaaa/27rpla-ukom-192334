<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kategori;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::with('kategori', 'kamar')->orderBy('nama_fasilitas')->get();
        $kategoris = Kategori::orderBy('name')->get();
        $kamars = Kamar::orderBy('nama_kamar')->get();

        return view('admin.fasilitas.index', [
            'fasilitas' => $fasilitas,
            'kategoris' => $kategoris,
            'kamars' => $kamars,
            'editId' => session('edit_id'),
        ]);

    }

    public function create()
    {
        return redirect()->route('admin.fasilitas.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:categories,id',
            'nama_fasilitas' => [
                'required',
                'max:100',
                Rule::unique('fasilitas', 'nama_fasilitas')->where(fn ($q) => $q->where('id_kategori', $request->id_kategori)),
            ],
            'id_kamar' => 'nullable|exists:kamars,id_kamar',
            'nilai_fasilitas' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        Fasilitas::create([
            'id_kategori' => $validated['id_kategori'],
            'nama_fasilitas' => $validated['nama_fasilitas'],
            'id_kamar' => $validated['id_kamar'] ?? null,
            'nilai_fasilitas' => $validated['nilai_fasilitas'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return redirect()->route('admin.fasilitas.index')->with('edit_id', $id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:categories,id',
            'nama_fasilitas' => [
                'required',
                'max:100',
                Rule::unique('fasilitas', 'nama_fasilitas')
                    ->where(fn ($q) => $q->where('id_kategori', $request->id_kategori))
                    ->ignore($id, 'id_fasilitas'),
            ],
            'id_kamar' => 'nullable|exists:kamars,id_kamar',
            'nilai_fasilitas' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $fasilita = Fasilitas::findOrFail($id);
        $fasilita->update([
            'id_kategori' => $validated['id_kategori'],
            'nama_fasilitas' => $validated['nama_fasilitas'],
            'id_kamar' => $validated['id_kamar'] ?? null,
            'nilai_fasilitas' => $validated['nilai_fasilitas'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Fasilitas::findOrFail($id)->delete();

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil dihapus.');
    }
}
