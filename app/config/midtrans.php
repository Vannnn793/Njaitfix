<?php

return [
    'isProduction' => false,
    'serverKey' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-xxx'),
    'clientKey' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-xxx'),
    'isSanitized' => true,
    'is3ds' => true,
];
