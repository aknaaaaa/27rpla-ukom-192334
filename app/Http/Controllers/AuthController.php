<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
// use laravel\Passport\HasApiTokens;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        return view('auth.register');
    
    // Gabungkan data request dengan nilai default
        // 1. Validasi Data
        $userData = Validator::make($request->all(), [
            'nama_user' => 'required|string|max:100', 
            'phone_number' => 'required|string|max:20', 
            'email' => 'required|email|unique:user,email', 
            'password' => 'required|min:6|confirmed',
        ]);

        if ($userData->fails()) {
            return redirect()->back()->withErrors($userData)->withInput();
        }

        $defaultRoleId = 2;

        $user = User::create([
            'id_role' => $defaultRoleId, 
            'nama_user' => $request->nama_user,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password), // Wajib di-hash
        ]);

        // 4. Berikan Respons Sukses
        return redirect()->back()->with('success_message', 'Pendaftaran berhasil! Silakan masuk menggunakan akun Anda.');
    }
    public function login(Request $request) 
    {
        return view('auth.login');
        $userData = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($userData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $userData->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        
        // Cek kredensial
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah.'
            ], 401);
        }

        $user = Auth::user()->load('role');
        $request->session()->regenerate(); // start session untuk guard web

        // Cek apakah Passport sudah dikonfigurasi dan HasApiTokens digunakan
        if (!method_exists($user, 'createToken')) {
             return response()->json([
                'success' => false,
                'message' => 'Passport/Sanctum belum dikonfigurasi pada model User.'
            ], 500);
        }

        // Generate Token menggunakan Passport
        $tokenResult = $user->createToken('authToken');
        $accessToken = $tokenResult->plainTextToken;

        $isAdmin = (int) ($user->id_role ?? 0) === 1;
        $redirectTo = $isAdmin ? route('admin.dashboard') : url('/');

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $accessToken,
            'redirect_to' => $redirectTo,
            'is_admin' => $isAdmin,
        ], 200);
    }
    public function check(Request $request) {
        $user = $request->user();

        if ($user) {
            return response()->json([
                'user' => $user,
            ], 200);
        }

        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    public function logout(Request $request) {
        $bearer = $request->bearerToken();
        $cookieToken = $request->cookie('sanctum_token');
        $tokenString = $bearer ?: ($cookieToken ? urldecode($cookieToken) : null);

        $accessToken = $tokenString ? PersonalAccessToken::findToken($tokenString) : null;
        $user = $accessToken?->tokenable ?? $request->user();

        // Jika ada token personal, hapus token itu
        if ($accessToken) {
            $accessToken->delete();
        }

        // Jika ada user terautentikasi, hapus semua token + logout session
        if ($user) {
            $user->tokens()->delete();
            Auth::guard('web')->logout();
        }

        // Invalidate session jika ada
        try {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (\Throwable $e) {
            // abaikan jika session tidak tersedia
        }

        // Jika request JSON (API), kembalikan JSON; jika tidak, redirect ke login
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil logout'
            ], 200);
        }

        return redirect()->route('layouts.login')->with('ok', 'Berhasil logout.');
    }
    public function user(Request $request)
{
    // Dengan Sanctum, user yang sudah login bisa langsung diambil dari request
    $user = $request->user(); // sama dengan Auth::user() saat pakai auth:sanctum

    return response()->json([
        'success' => true,
        'message' => 'Detail profil pengguna',
        'data' => [
            'id_user'     => $user->id_user,
            'nama_user'   => $user->nama_user,
            'email'       => $user->email,
            'phone_number'=> $user->phone_number,
            // tambahin field lain kalau ada
        ]
    ], 200);
}

}
