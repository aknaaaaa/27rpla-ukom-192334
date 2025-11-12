<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login',  [AuthController::class, 'login'])->middleware('sanctum.guest')->name('auth.api');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'check']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});


// (opsional) endpoint helper ketika sudah login (dengan token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', fn (\Illuminate\Http\Request $r) => $r->user());
    Route::get('check-auth', [AuthController::class, 'check']);
});


