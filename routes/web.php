<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PemesananController;

Route::middleware('guest')->group(function () {
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
Route::post('/kamar/pilih/{id_kamar}', [PemesananController::class, 'store'])->name('pemesanan.store');

Route::get('/pembayaran', [PemesananController::class, 'index'])->name('pembayaran.index');
Route::put('/pembayaran/{id}', [PemesananController::class, 'update'])->name('pemesanan.update');
Route::delete('/pembayaran/{id}', [PemesananController::class, 'destroy'])->name('pemesanan.destroy');
Route::resource('pemesanan', PemesananController::class);

    Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
    
});

Route::middleware('auth')->group(function () {
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

    
});
