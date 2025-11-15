<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayoutsController extends Controller
{
    public function index()
    {
        // Panggil view index yang ada di resources/views/layouts/index.blade.php
        return view('layouts.index');
    }
    public function daftar()
    {
        return view('auth.register');
    }
    public function masuk(){
        return view('auth.login');
    }
    public function profile(){
        $user = Auth::user();

        return view('profile.profile', [
            'user' => $user,
        ]);
    }
}
