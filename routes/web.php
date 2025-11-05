<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;

// 🔹 Halaman utama langsung ke controller
Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
