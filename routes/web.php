<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\KamarController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [LayoutsController::class, 'daftar'])->name('layouts.register');
    Route::get('/login', [LayoutsController::class, 'masuk'])->name('layouts.login');
    Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');
});
