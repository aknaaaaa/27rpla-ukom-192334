<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    // Redirect accidental GET visits on the API register endpoint to the web form
    Route::get('/register', fn () => redirect()->route('register'))->middleware('web');

    Route::post('/login',  [AuthController::class, 'login'])->middleware(['web', 'sanctum.guest'])->name('auth.api');
    // Use a unique name to avoid clashing with the web "register" page route
    Route::post('/register', [AuthController::class, 'register'])->middleware('web')->name('auth.api.register');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('web');

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
Route::middleware('web')->get('/payments/status/{orderId}', [PaymentController::class, 'status'])->name('api.payments.status');

// Webhook/notification Midtrans (tanpa CSRF)
Route::post('/midtrans/notify', [PaymentController::class, 'notify'])->name('midtrans.notify');
