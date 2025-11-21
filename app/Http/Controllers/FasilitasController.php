<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kategori;
use App\Models\Kamar;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::with('kategori', 'kamar')->get();
return view('admin.fasilitas.index', compact('fasilitas'));

    }

    public function create()
    {
        $kategoris = Kategori::all();
        $kamars = Kamar::all();
        return view('admin.fasilitas.create', compact('kategoris', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_fasilitas' => 'required|max:100',
            'id_kamar' => 'nullable',
            'nilai_fasilitas' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        Fasilitas::create($request->all());

        return redirect()->route('admin.fasilitas.index')
                         ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $fasilita = Fasilitas::findOrFail($id);
        $kategoris = Kategori::all();
        $kamars = Kamar::all();
        return view('admin.fasilitas.edit', compact('fasilita', 'kategoris', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_fasilitas' => 'required|max:100',
            'id_kamar' => 'nullable',
            'nilai_fasilitas' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $fasilita = Fasilitas::findOrFail($id);
        $fasilita->update($request->all());

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
