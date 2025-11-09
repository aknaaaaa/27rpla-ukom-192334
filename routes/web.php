<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\KamarController;

Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');