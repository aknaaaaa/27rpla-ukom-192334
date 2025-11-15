<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class EnsureSanctumAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        $cookieToken = $request->cookie('sanctum_token');
        $token = $request->bearerToken() ?? ($cookieToken ? urldecode($cookieToken) : null);

        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);

            if ($accessToken) {
                $user = $accessToken->tokenable;
                Auth::guard('web')->login($user);

                $request->setUserResolver(function () use ($user) {
                    return $user;
                });

                return $next($request);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return redirect()->route('layouts.register');
    }
}
