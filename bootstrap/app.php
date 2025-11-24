<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureSanctumGuest;
use App\Http\Middleware\EnsureSanctumAuthenticated;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

$caPath = __DIR__.'/../storage/cacert.pem';
if (file_exists($caPath)) {
    $caReal = realpath($caPath) ?: $caPath;
    putenv('CURL_CA_BUNDLE='.$caReal);
    putenv('SSL_CERT_FILE='.$caReal);
    @ini_set('curl.cainfo', $caReal);
    @ini_set('openssl.cafile', $caReal);
    stream_context_set_default([
        'ssl' => [
            'cafile' => $caReal,
            'verify_peer' => true,
            'verify_peer_name' => true,
        ],
    ]);
}

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
            'api/auth/register',
            'api/auth/logout',
            // Allow logout via GET/POST without CSRF to prevent 419 on stale sessions
            'logout',
            'logout/*',
            'admin/rooms',
            'admin/rooms/*',
            'api/payments/charge',
            'api/midtrans/notify',
        ]);

        // cookie token diset dari client, jadi jangan dienkripsi/didekripsi oleh Laravel
        $middleware->encryptCookies([
            'sanctum_token',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
