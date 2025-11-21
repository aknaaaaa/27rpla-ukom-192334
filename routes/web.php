<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\AdminKamarController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KategoriController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [LayoutsController::class, 'index'])->name('layouts.index');
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
Route::get('/kamar/{id}', [KamarController::class, 'show'])->name('kamar.show');

// ==================== AUTH ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('layouts.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('layouts.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.api');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('sanctum.session');

// ==================== CUSTOMER ROUTES ====================
Route::middleware('sanctum.session')->group(function () {
    Route::get('/profile', [LayoutsController::class, 'profile'])->name('profile.profile');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::get('/checkout', [LayoutsController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success', function () {
        $payment = session()->pull('last_payment');
        abort_if(!$payment, 403);
        return view('kamar.payment-success', ['payment' => $payment]);
    })->name('checkout.success');
    Route::post('/payments/charge', [PaymentController::class, 'charge'])->name('payments.charge');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['sanctum.session', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [LayoutsController::class, 'adminDashboard'])->name('dashboard');
    
    // Kamar Management
    Route::get('/rooms', [AdminKamarController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [AdminKamarController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{id}/edit', [AdminKamarController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{id}', [AdminKamarController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{id}', [AdminKamarController::class, 'destroy'])->name('rooms.destroy');
    
    // Orders
    Route::get('/orders', [\App\Http\Controllers\AdminPemesananController::class, 'index'])->name('orders');
    
    // Customers
    Route::get('/customers', [AdminPelangganController::class, 'index'])->name('pelanggan');
    Route::get('/customers/{id}', [AdminPelangganController::class, 'show'])->name('pelanggan.show');
    
    // Fasilitas & Kategori
    Route::resource('/fasilitas', FasilitasController::class);
    Route::resource('/kategori', KategoriController::class);
});