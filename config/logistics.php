<?php
return [
    'provider' => env('LOGISTICS_PROVIDER', 'mock'),
    'mock' => [
        'enabled' => env('MOCK_LOGISTICS', true),
        'minutes_between_status' => 2,
    ],
    'shiprocket' => [
        'email' => env('SHIPROCKET_EMAIL'),
        'password' => env('SHIPROCKET_PASSWORD'),
        'webhook_secret' => env('SHIPROCKET_WEBHOOK'),
    ]
];
