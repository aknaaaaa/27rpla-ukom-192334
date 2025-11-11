<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login',  [AuthController::class, 'login'])->name('auth.api');
    Route::get('/profile', [AuthController::class, 'check'])->middleware('auth:api')->name('auth.api.check');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.api.logout');
});

// (opsional) endpoint helper ketika sudah login (dengan token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', fn (\Illuminate\Http\Request $r) => $r->user());
    Route::get('check-auth', [AuthController::class, 'check']);
});


