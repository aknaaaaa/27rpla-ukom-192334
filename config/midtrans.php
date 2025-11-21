<?php 
return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    // legacy alias
    'client-key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION'),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED'),
    'is_3ds' => env('MIDTRANS_IS_3DS'),
    'verify_ssl' => env('MIDTRANS_VERIFY_SSL', true),
];
