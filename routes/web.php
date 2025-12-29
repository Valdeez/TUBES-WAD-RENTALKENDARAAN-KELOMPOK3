<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Models\Pembayaran; 
use App\Http\Controllers\MotorController;
use App\Models\Motor;

Route::get('/', function () {
    return view('home');
});
Route::get('/pembayaran', function(){
 return view('pembayaran.createPembayaran');
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
