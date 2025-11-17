<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login',  [AuthController::class, 'login'])->middleware(['web', 'sanctum.guest'])->name('auth.api');
    Route::post('/register', [AuthController::class, 'register'])->middleware('web')->name('register');
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
