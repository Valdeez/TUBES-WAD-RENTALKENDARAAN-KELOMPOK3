<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\PeminjamanController;
use App\Models\Motor;

Route::get('/', function () {
    return view('home');
});
Route::get('motor', [MotorController::class, 'index'])->name('motor');
Route::get('/motor/{id}', [MotorController::class, 'show'])->name('motor.detail');

Route::get('/motor/create', [MotorController::class, 'create'])->name('motor.create');

// Route Proses Simpan Motor (Action)
Route::post('/motor', [MotorController::class, 'store'])->name('motor.store');
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
Route::get('/peminjaman/create/{id}/{type}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');