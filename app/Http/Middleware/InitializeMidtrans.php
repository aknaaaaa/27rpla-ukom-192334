<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Midtrans\Config;

class InitializeMidtrans
{
    public function handle(Request $request, Closure $next)
    {
        Config::$serverKey = trim((string) config('midtrans.server_key', ''));
        Config::$clientKey = trim((string) config('midtrans.client_key', ''));
        Config::$isProduction = (bool) filter_var(config('midtrans.is_production', false), FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized = (bool) filter_var(config('midtrans.is_sanitized', true), FILTER_VALIDATE_BOOLEAN);
        Config::$is3ds = (bool) filter_var(config('midtrans.is_3ds', true), FILTER_VALIDATE_BOOLEAN);

        $verify = (bool) filter_var(config('midtrans.verify_ssl', true), FILTER_VALIDATE_BOOLEAN);
        Config::$curlOptions = Config::$curlOptions ?: [];
        Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = $verify;
        Config::$curlOptions[CURLOPT_SSL_VERIFYHOST] = $verify ? 2 : 0;
        if (!isset(Config::$curlOptions[CURLOPT_HTTPHEADER])) {
            Config::$curlOptions[CURLOPT_HTTPHEADER] = [];
        }

        return $next($request);
    }
}
