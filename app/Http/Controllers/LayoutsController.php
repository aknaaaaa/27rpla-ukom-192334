<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayoutsController extends Controller
{
    public function index()
    {
        // Panggil view index yang ada di resources/views/layouts/index.blade.php
        return view('layouts.index');
    }
    public function daftar()
    {
        return view('layouts.register');
    }
    public function masuk(){
        return view('layouts.login');
    }
    public function profile(){
        return view('profile.profile');
    }
}
