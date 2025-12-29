<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController; 
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