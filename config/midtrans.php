<?php

return [
    'server_key'    => env('MIDTRANS_SERVER_KEY'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', env('MIDTRANS_PRODUCTION', false)),
    'sanitized'     => env('MIDTRANS_IS_SANITIZED', env('MIDTRANS_SANITIZED', true)),
    '3ds'           => env('MIDTRANS_IS_3DS', env('MIDTRANS_3DS', true)),
];
