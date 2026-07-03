<?php

return [

    'provider' => env(
        'PAYMENT_PROVIDER',
        'mock'
    ),

    'capture_mode' => env(
        'PAYMENT_CAPTURE_MODE',
        'automatic'
    ),

    'mock' => [

        'payment' => env(
            'MOCK_PAYMENT',
            true
        ),

        'refund' => env(
            'MOCK_REFUND',
            true
        ),

        'payout' => env(
            'MOCK_PAYOUT',
            true
        ),

    ],

];
