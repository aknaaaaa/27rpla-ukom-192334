<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\AdminKamarController;

Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');
Route::get('/admin/dashboard', [LayoutsController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('/admin/rooms', [AdminKamarController::class, 'index'])->name('admin.rooms');
Route::post('/admin/rooms', [AdminKamarController::class, 'store'])->name('admin.rooms.store');

Route::middleware('guest')->group(function () {
    Route::get('/register', [LayoutsController::class, 'daftar'])->name('register');
    Route::get('/login', [LayoutsController::class, 'masuk'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
});

Route::middleware('sanctum.session')->group(function () {
    Route::get('/profile', [LayoutsController::class, 'profile'])->name('profile.profile');
});
