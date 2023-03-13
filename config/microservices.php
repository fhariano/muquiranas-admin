<?php

return [
    'available' => [
        'micro_auth' => [
            'url' => env('MICRO_AUTH_URL'),
        ],
    ],
    'minStock' => env('MIN_STOCK'),
    'stopPromo' => env('STOP_PROMO'),
];
