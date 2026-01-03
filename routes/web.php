<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\Motor;
use App\Models\Mobil;

// Untuk Admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Motor Admin
    Route::get('/motor/create', [MotorController::class, 'create'])->name('motor.create');
    Route::post('/motor', [MotorController::class, 'store'])->name('motor.store');
    Route::get('/motor/{id}/edit', [MotorController::class, 'edit'])->name('motor.edit');
    Route::put('/motor/{id}', [MotorController::class, 'update'])->name('motor.update');
    Route::delete('/motor/{id}', [MotorController::class, 'destroy'])->name('motor.destroy');

    // Mobil Admin
    Route::get('/mobil/create', [MobilController::class, 'create'])->name('mobil.create');
    Route::post('/mobil', [MobilController::class, 'store'])->name('mobil.store');
    Route::get('/mobil/{id}/edit', [MobilController::class, 'edit'])->name('mobil.edit');
    Route::put('/mobil/{id}', [MobilController::class, 'update'])->name('mobil.update');
    Route::delete('/mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');

    // Pembayaran Admin
    Route::prefix('admin')->group(function () {
        Route::get('/pembayaran', [PembayaranController::class, 'adminIndex'])->name('admin.pembayaran.index');
        Route::patch('/pembayaran/{id}/verify', [PembayaranController::class, 'verify'])->name('admin.pembayaran.verify');
        Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('admin.pembayaran.destroy');
    });
});

// Publik
Route::get('/', function () {
    $motors = Motor::latest()->limit(4)->get();
    $mobils = Mobil::latest()->limit(4)->get();
    return view('home', compact('motors', 'mobils'));
})->name('home');

// Auth
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::get('/register', fn () => view('auth.register'))->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Motor
Route::get('motor', [MotorController::class, 'index'])->name('motor.index');
Route::get('/motor/{id}', [MotorController::class, 'show'])->name('motor.detail');

// Mobil
Route::get('mobil', [MobilController::class, 'index'])->name('mobil.index');
Route::get('/mobil/{id}', [MobilController::class, 'show'])->name('mobil.detail');

// Untuk Pelanggan
Route::middleware(['auth'])->group(function () {
    // User
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.delete');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/peminjaman/create/{id}/{type}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Pembayaran
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');

    // Review
    Route::get('/review/create/{peminjaman_id}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
});