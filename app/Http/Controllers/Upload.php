<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Upload extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'image' => ['required','image','max:4096'], // 4MB contoh
    ]);

    $file = $request->file('image');

    $upload = Cloudinary::upload(
        $file->getRealPath(),
        [
            'folder' => env('CLOUDINARY_UPLOAD_FOLDER'),
        ]
    );

    $secureUrl = $upload->getSecurePath();  // URL https siap pakai
    $publicId  = $upload->getPublicId();    // simpan di DB untuk delete nanti

    // simpan $secureUrl / $publicId ke DB sesuai kebutuhan
    return back()->with('url', $secureUrl);
}
}
