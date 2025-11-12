<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Delete extends Controller
{

public function destroy(string $publicId)
{
    Cloudinary::destroy($publicId); // hapus berdasarkan public_id yang kamu simpan
    return back()->with('status', 'Gambar dihapus');
}

}
