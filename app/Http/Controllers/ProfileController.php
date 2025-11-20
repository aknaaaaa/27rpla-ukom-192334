<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Pengguna tidak ditemukan.',
            ], 401);
        }

        $request->validate([
            'avatar' => ['required', 'image', 'max:4096', 'mimes:jpg,jpeg,png,webp'],
        ]);

        $path = $request->file('avatar')->store('avatars', 'public');
        $relativeUrl = Storage::url($path); // contoh: /storage/avatars/xxx.jpg

        if ($user->avatar_url && Str::startsWith($user->avatar_url, '/storage/')) {
            $previous = Str::after($user->avatar_url, '/storage/');
            Storage::disk('public')->delete($previous);
        }

        $user->avatar_url = $relativeUrl;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diperbarui.',
            'avatar_url' => asset($relativeUrl),
        ]);
    }
}