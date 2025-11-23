<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::latest()->get();

        return view('kamar.index', compact('kamars'));
    }

    public function show($id)
    {
        $kamar = Kamar::findOrFail($id);

        return view('kamar.detail', compact('kamar'));
    }
}
