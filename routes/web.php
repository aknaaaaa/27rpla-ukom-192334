<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\KamarController;

Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [LayoutsController::class, 'daftar'])->name('layouts.register');
    Route::get('/login', [LayoutsController::class, 'masuk'])->name('layouts.login');
});

Route::middleware('sanctum.session')->group(function () {
    Route::get('/profile', [LayoutsController::class, 'profile'])->name('profile.profile');
});
