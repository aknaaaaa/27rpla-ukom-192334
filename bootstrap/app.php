<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureSanctumGuest;
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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'sanctum.guest' => EnsureSanctumGuest::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Alias middleware yang kamu pakai di routes:
        $middleware->alias([
            'auth'  => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
