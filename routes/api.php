<?php

use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    // Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('auth.api');
    Route::get('/profile', [AuthController::class, 'check'])->name('auth.api.check');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.api.logout');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


