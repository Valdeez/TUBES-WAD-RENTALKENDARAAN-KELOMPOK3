<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  string[]  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        //check buat apakah udah login atau si role ini ada atau gk
        if (!$user || !in_array($user->role, $roles)) {
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses Ditolak. Anda tidak memiliki izin.'], 403);
            }
            
            return redirect()->route('home')->with('error', 'Akses Ditolak. Anda tidak memiliki izin.');
        }
        
        return $next($request);
    }
}