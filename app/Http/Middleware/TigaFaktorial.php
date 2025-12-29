<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TigaFaktorial
{
    // Pastikan parameter handle sesuai standar
    public function handle(Request $request, Closure $next): Response
    {
        // buat cek autentikasi token
        if (!Auth::check()) {
            return response()->json(['message' => 'Token tidak ditemukan atau tidak valid.'], 401);
        }

        //  buat check role admin
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Akses Ditolak. Anda bukan Administrator.'], 403);
        }

       
        return $next($request); 
    }
}