<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'gst' => [
        'client_id' => env('GST_CLIENT_ID'),
        'client_secret' => env('GST_CLIENT_SECRET'),
    ],
    'pan' => [
        'api_key' => env('PAN_API_KEY'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'payment_mode' => env('PAYMENT_MODE', 'mock'),
    'razorpay' => [
        'key_id'        => env('RAZORPAY_KEY_ID'),
        'key_secret'    => env('RAZORPAY_KEY_SECRET'),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    ],

    'razorpayx' => [
        'key'           => env('RAZORPAYX_KEY'),
        'secret'        => env('RAZORPAYX_SECRET'),
        'webhook_secret' => env('RAZORPAYX_WEBHOOK_SECRET'),
    ],
    'shiprocket' => [
        'email'           => env('SHIPROCKET_EMAIL'),
        'password'        => env('SHIPROCKET_PASSWORD'),
        'token'           => env('SHIPROCKET_TOKEN'), // auto-generated token (store temporarily)
        'base_url'        => env('SHIPROCKET_BASE_URL', 'https://apiv2.shiprocket.in/v1/external'),
        'webhook_secret'  => env('SHIPROCKET_WEBHOOK_SECRET'),
        'pickup_pincode'  => env('SHIPROCKET_PIN'),
        'pickup_location' => env('SHIPROCKET_PICKUP_LOCATION'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    'fast2sms' => [
        'key' => env('FAST2SMS_KEY'),
    ],

];
