<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;     
use App\Http\Controllers\PembayaranController;

// ini buat public
// url api/register
Route::post('/register', [AuthController::class, 'register']);
// url api/login
Route::post('/login', [AuthController::class, 'login']);
// ini buat private
Route::middleware(['auth:sanctum'])->group(function () {

    // Logout url api/logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // crud Pembayaran 
    // url /api/pembayaran
    Route::apiResource('pembayaran', PembayaranController::class);

    // 
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
use App\Http\Controllers\MobilController;
use App\Http\Controllers\MotorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('mobils', MobilController::class);
Route::apiResource('motors', MotorController::class);
