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

        $user = Auth::user();

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

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $accessToken,
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