<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\AdminKamarController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;

Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');
Route::get('/admin/dashboard', [LayoutsController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('/admin/rooms', [AdminKamarController::class, 'index'])->name('admin.rooms');
Route::post('/admin/rooms', [AdminKamarController::class, 'store'])->name('admin.rooms.store');
Route::get('/admin/rooms/{id}/edit', [AdminKamarController::class, 'edit'])->name('admin.rooms.edit');
Route::put('/admin/rooms/{id}', [AdminKamarController::class, 'update'])->name('admin.rooms.update');
Route::delete('/admin/rooms/{id}', [AdminKamarController::class, 'destroy'])->name('admin.rooms.destroy');
Route::get('/admin/orders', [\App\Http\Controllers\AdminPemesananController::class, 'index'])->name('admin.orders');
Route::get('/admin/customers', [AdminPelangganController::class, 'index'])->name('admin.pelanggan');
Route::get('/admin/customers/{id}', [AdminPelangganController::class, 'show'])->name('admin.pelanggan.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [LayoutsController::class, 'daftar'])->name('layouts.register');
    Route::get('/login', [LayoutsController::class, 'masuk'])->name('layouts.login');
});

Route::middleware('sanctum.session')->group(function () {
    Route::get('/profile', [LayoutsController::class, 'profile'])->name('profile.profile');
    Route::get('/checkout', [LayoutsController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success', function () {
        abort_if(session('last_payment.status') !== 'success', 403);
        return view('kamar.payment-success');
    })->name('checkout.success');
    Route::post('/payments/charge', [PaymentController::class, 'charge'])->name('payments.charge');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
