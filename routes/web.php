<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorController;
use App\Models\Motor;

Route::get('/', function () {
    return view('home');
});
Route::get('motor', [MotorController::class, 'index'])->name('motor');
Route::get('/motor/{id}', [MotorController::class, 'show'])->name('motor.detail');

Route::get('/motor/create', [MotorController::class, 'create'])->name('motor.create');

// Route Proses Simpan Motor (Action)
Route::post('/motor', [MotorController::class, 'store'])->name('motor.store');