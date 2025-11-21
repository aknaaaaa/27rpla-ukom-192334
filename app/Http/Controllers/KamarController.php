<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Models\Kategori;


class KamarController extends Controller
{
    public function index(Request $request)
    {
            $rooms = Kamar::all();
    $categories = Kategori::with('items')->get();

        return view('admin.rooms.index', compact('rooms', 'categories'));
    }

    public function show($id)
    {
        $kamar = Kamar::findOrFail($id);

        return view('kamar.detail', compact('kamar'));
    }
}
