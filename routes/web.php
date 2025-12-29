<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Models\Pembayaran; 
use App\Http\Controllers\MotorController;
use App\Models\Motor;

Route::get('/', function () {
    return view('home');
});
Route::middleware(['auth'])->group(function () {
    // punya user atau penyewa
    Route::get('/pembayaran', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/history', [PembayaranController::class, 'index'])->name('pembayaran.history');
});
// punya admin
Route::prefix('admin')->group(function () {
    Route::get('/pembayaran', [PembayaranController::class, 'adminIndex'])->name('admin.pembayaran.index');
    Route::patch('/pembayaran/{id}/verify', [PembayaranController::class, 'verify'])->name('admin.pembayaran.verify');

});
Route::get('motor', [MotorController::class, 'index'])->name('motor');
Route::get('/motor/create', [MotorController::class, 'create'])->name('motor.create');
Route::post('/motor', [MotorController::class, 'store'])->name('motor.store');

Route::get('/motor/{id}', [MotorController::class, 'show'])->name('motor.detail');

// Edit (Menampilkan Form)
Route::get('/motor/{id}/edit', [MotorController::class, 'edit'])->name('motor.edit');

// Update (Proses Simpan Edit) -> Perhatikan Method PUT
Route::put('/motor/{id}', [MotorController::class, 'update'])->name('motor.update');

// Delete (Proses Hapus) -> Perhatikan Method DELETE
Route::delete('/motor/{id}', [MotorController::class, 'destroy'])->name('motor.destroy');
