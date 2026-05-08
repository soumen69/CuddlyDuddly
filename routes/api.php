<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ValidationController;
use App\Http\Controllers\Webhooks\RazorpayWebhookController;
use App\Http\Controllers\Webhooks\RazorpayXWebhookController;
use App\Http\Controllers\Webhooks\ShiprocketWebhookController;

Route::prefix('validate')->group(function () {
    Route::get('/gst/{gst}', [ValidationController::class, 'validateGST']);
    Route::get('/pan/{pan}', [ValidationController::class, 'validatePAN']);
});

Route::post('/webhooks/razorpay', [RazorpayWebhookController::class, 'handle']);
Route::post('/webhooks/razorpayx', [RazorpayXWebhookController::class, 'handle']);
Route::post('/shiprocket/webhook', [ShiprocketWebhookController::class, 'handle']);
