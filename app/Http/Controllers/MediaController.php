<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MediaController extends Controller
{
    public function index()
    {

        $items = session('media_items', []);
        return view('media.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required','image','max:4096','mimes:jpg,jpeg,png,webp'],
        ]);

        $upload = Cloudinary::upload(
            $request->file('image')->getRealPath(),
            ['folder' => env('CLOUDINARY_UPLOAD_FOLDER')]
        );

        $item = [
            'public_id' => $upload->getPublicId(),
            'url'       => $upload->getSecurePath(),
        ];

        // simpan ke DB sesuai kebutuhan; demo pakai session
        $items = session('media_items', []);
        $items[] = $item;
        session(['media_items' => $items]);

        return redirect()->route('media.index')->with('ok', 'Upload sukses');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'public_id' => ['required','string'],
        ]);

        Cloudinary::destroy($request->public_id);

        // hapus dari storage lokal/DB; demo: dari session
        $items = collect(session('media_items', []))
            ->reject(fn($x) => $x['public_id'] === $request->public_id)
            ->values()->all();
        session(['media_items' => $items]);

        return back()->with('ok', 'Terhapus');
    }
}
