<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::with('kamar')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $kamars = Kamar::all();
        return view('admin.kategori.create', compact('kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required',
            'nama_kategori' => 'required|max:100'
        ]);

        Kategori::create($request->all());

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kamars = Kamar::all();

        return view('admin.kategori.edit', compact('kategori', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kamar' => 'required',
            'nama_kategori' => 'required|max:100'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
