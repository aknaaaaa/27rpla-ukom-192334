<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;

// 🔹 Halaman utama langsung ke controller
Route::get('/layouts', [LayoutsController::class, 'index'])->name('layouts.index');
