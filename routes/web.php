<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\KamarController;
<<<<<<< HEAD


Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');

=======

Route::middleware('guest')->group(function () {
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');
    Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
    
});

Route::middleware('auth')->group(function () {
    Route::get('/register', [LayoutsController::class, 'daftar'])->name('layouts.register');
    Route::get('/login', [LayoutsController::class, 'masuk'])->name('layouts.login');
    
});
>>>>>>> c744583985de79c63527125b81123ee127e9ef34
