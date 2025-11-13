<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSanctumGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('sanctum')->check() || $request->user('sanctum')) {
            // Sudah login → tolak akses ke login/register
            return response()->json([
                'message' => 'Sudah login, tidak boleh mengakses endpoint ini.'
            ], 409);
        }

        return $next($request);
    }
}
