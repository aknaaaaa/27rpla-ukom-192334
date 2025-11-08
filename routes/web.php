<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;

// 🔹 Halaman utama langsung ke controller
Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
Route::get('/register', [LayoutsController::class, 'daftar'])->name('layouts.register');
Route::get('/login', [LayoutsController::class, 'masuk'])->name('layouts.login');

Route::post('/register', [AuthController::class, 'register'])->name('register');
