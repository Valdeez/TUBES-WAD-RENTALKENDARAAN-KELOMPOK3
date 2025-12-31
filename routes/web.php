<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Models\Pembayaran; 
use App\Http\Controllers\MotorController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ReviewController;
use App\Models\Motor;
use App\Models\Mobil;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::middleware(['auth'])->group(function () {
    // punya user atau penyewa
});
Route::get('/pembayaran/{id}', [PembayaranController::class, 'create'])->name('pembayaran.create');
Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('admin.pembayaran.destroy');
// punya admin
Route::prefix('admin')->group(function () {
    Route::get('/pembayaran', [PembayaranController::class, 'adminIndex'])->name('admin.pembayaran.index');
    Route::patch('/pembayaran/{id}/verify', [PembayaranController::class, 'verify'])->name('admin.pembayaran.verify');

});
Route::get('motor', [MotorController::class, 'index'])->name('motor.index');
Route::get('/motor/create', [MotorController::class, 'create'])->name('motor.create');
Route::post('/motor', [MotorController::class, 'store'])->name('motor.store');

Route::get('/motor/{id}', [MotorController::class, 'show'])->name('motor.detail');

// Edit (Menampilkan Form)
Route::get('/motor/{id}/edit', [MotorController::class, 'edit'])->name('motor.edit');

// Update (Proses Simpan Edit) -> Perhatikan Method PUT
Route::put('/motor/{id}', [MotorController::class, 'update'])->name('motor.update');

// Route Proses Simpan Motor (Action)
Route::post('/motor', [MotorController::class, 'store'])->name('motor.store');
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
Route::get('/peminjaman/create/{id}/{type}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
// Delete (Proses Hapus) -> Perhatikan Method DELETE
Route::delete('/motor/{id}', [MotorController::class, 'destroy'])->name('motor.destroy');
Route::get('/review/create/{peminjaman_id}', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
Route::delete('/review{review}', [ReviewController::class, 'destroy'])->name('review.destroy');

// Mobil Routes
Route::get('mobil', [MobilController::class, 'index'])->name('mobil.index');
Route::get('/mobil/create', [MobilController::class, 'create'])->name('mobil.create');
Route::post('/mobil', [MobilController::class, 'store'])->name('mobil.store');

Route::get('/mobil/{id}', [MobilController::class, 'show'])->name('mobil.detail');
// Edit (Menampilkan Form)
Route::get('/mobil/{id}/edit', [MobilController::class, 'edit'])->name('mobil.edit');

// Update (Proses Simpan Edit) -> Perhatikan Method PUT
Route::put('/mobil/{id}', [MobilController::class, 'update'])->name('mobil.update');

// Route Proses Simpan Mobil (Action)
Route::post('/mobil', [MobilController::class, 'store'])->name('mobil.store');
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
Route::get('/peminjaman/create/{id}/{type}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
// Delete (Proses Hapus) -> Perhatikan Method DELETE
Route::delete('/mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');
Route::get('/review/create/{peminjaman_id}', [ReviewController::class, 'create'])->name('review.create');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');