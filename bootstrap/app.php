<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureSanctumGuest;
use App\Http\Middleware\EnsureSanctumAuthenticated;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // aktifkan stateful agar cookies/CSRF berlaku untuk API
        $middleware->appendToGroup('api', EnsureFrontendRequestsAreStateful::class);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'sanctum.guest' => EnsureSanctumGuest::class,
            'sanctum.session' => EnsureSanctumAuthenticated::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        // kecualikan endpoint API auth dari pengecekan CSRF agar bisa dipanggil tanpa cookie XSRF
        $middleware->validateCsrfTokens([
            'api/auth/login',
            'api/auth/logout',
        ]);

        // cookie token diset dari client, jadi jangan dienkripsi/didekripsi oleh Laravel
        $middleware->encryptCookies([
            'sanctum_token',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
