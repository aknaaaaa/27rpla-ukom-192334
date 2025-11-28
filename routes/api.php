<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminKamarController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'check']);
    });
});


// (opsional) endpoint helper ketika sudah login (dengan token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('check-auth', [AuthController::class, 'check']);
});

// Charge Midtrans, gunakan middleware web agar session/auth dapat terpakai.
Route::middleware('web')->post('/payments/charge', [PaymentController::class, 'charge'])->name('api.payments.charge');
Route::get('/payments/status/{orderId}', [PaymentController::class, 'status'])->name('api.payments.status');

// Webhook/notification Midtrans (tanpa CSRF)
Route::post('/midtrans/notify', [PaymentController::class, 'notify'])->name('midtrans.notify');

// API untuk fetch fasilitas berdasarkan kategori
Route::get('/kategoris/{kategoriId}/fasilitas', [AdminKamarController::class, 'getFasilitas'])->name('api.kategoris.fasilitas');
