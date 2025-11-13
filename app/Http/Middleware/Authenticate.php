<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redirect user ke halaman login jika belum autentikasi.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('layouts.index'); // arahkan ke halaman login kamu
        }
        return null;
    }
}
