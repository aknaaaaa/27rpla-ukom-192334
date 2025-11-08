<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use laravel\Passport\HasApiTokens;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        // Tentukan ID Role Default Anda
    $defaultRoleId = 2; 
    
    // Gabungkan data request dengan nilai default
    $dataToValidate = array_merge($request->all(), [
        'id_role' => $defaultRoleId // Tambahkan nilai default ke array validasi
    ]);
        // 1. Validasi Data
        $userData = Validator::make($dataToValidate, [
            // Validasi untuk kolom 'nama_user'
            'nama_user' => 'required|string|max:100', 
            
            // Validasi untuk kolom 'phone_number'
            'phone_number' => 'required|string|max:20', 
            
            // Pastikan Anda menggunakan nama tabel yang benar: 'user' atau 'users'
            'email' => 'required|email|unique:user,email', 
            
            'password' => 'required|min:6',
            'id_role' => 'required|integer|exists:roles,id_role'
        ]);

        if ($userData->fails()) {
            // Jika validasi gagal, kembalikan error 422
            return response()->json($userData->errors(), 422);
        }

        // 2. Tentukan ID Role Default
        // Anda HARUS tahu ID role mana yang merupakan "Pelanggan" (misal: 2)
        // Jika Anda belum membuat tabel 'roles', Anda harus membuatnya terlebih dahulu.
        $defaultRoleId = 2; // Ganti dengan ID role "Pelanggan" yang sesungguhnya

        // 3. Simpan User ke Database
        $user = User::create([
            'id_role' => $defaultRoleId, 
            'nama_user' => $request->nama_user,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password), // Wajib di-hash
        ]);

        // 4. Berikan Respons Sukses
        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil. Silakan login.',
            'user' => $user->only(['id_user', 'nama_user', 'email']) // Hanya tampilkan data aman
        ], 201);
    }
    public function login(Request $request) {
        $userData = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($userData->fails()) {
            return response()->json($userData->errors(), 422);
        }
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email dan Password salah'
            ], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('authToken')->accessToken;
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ], 200);
    }
    public function check(Request $request) {
        if(Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $data = [
                'user' => $user,
            ];
            return response()->json($data, 200);
        } else {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }
    public function logout(Request $request) {
        $auth = auth('api');
        try {
            if ($auth->check()) {
                $auth->user()->token()->revoke();
                $auth->user()->token()->delete();
                $pesan = [
                    'success' => true,
                    'message' => 'Berhasil logout'
                ];
                $code = 200;
            } else {
                $pesan = [
                    'success' => false,
                    'message' => 'Sedang tidak login'
                ];
                $code = 401;
            }
        } catch (Exception $e) {
            $pesan = [
                'success' => false,
                'message' => 'Gagal logout'
            ];
            $code = 401;
        }
        return response()->json($pesan, $code);
    }
}