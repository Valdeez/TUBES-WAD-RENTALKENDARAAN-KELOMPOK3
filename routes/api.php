<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembayaranController;


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

// prive route butuh toke barerr
Route::middleware(['auth:sanctum'])->group(function () {

    // Logout url api/logout -> buthh token aktif
    Route::post('/logout', [AuthController::class, 'logout']);

    // route yang bisa di akses semua user
    // index (GET /api/pembayaran)
    // show (GET /api/pembayaran/{id})
    // store (POST /api/pembayaran)
    Route::resource('pembayaran', PembayaranController::class)->only([
        'index', 'show', 'store'
    ]);
    
    // 2. Route yang HANYA bisa diakses oleh ADMIN (Update & Delete)
    Route::middleware('role:admin')->group(function () {
        
        // ini update pembayarann Admin Only
        Route::match(['put', 'patch'], '/pembayaran/{pembayaran}', [PembayaranController::class, 'update']);
        
        // delete pembayaran Admin Only
        Route::delete('/pembayaran/{pembayaran}', [PembayaranController::class, 'destroy']);
    });
    
    // unutk check yang sednag login
    Route::get('/user', function (Request $request) {
        return $request->user();
        });
});