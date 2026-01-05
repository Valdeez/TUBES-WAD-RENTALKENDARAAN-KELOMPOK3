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
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, beri error 403 (Forbidden)
        abort(403, 'Akses ditolak! Anda bukan Admin.');
    }
}