<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Models\Pembayaran; 

Route::get('/', function () {
    return view('home');
});
Route::get('/pembayaran', function(){
 return view('pembayaran.createPembayaran');
});