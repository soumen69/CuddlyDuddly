<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Console\Commands\AutoSettleOrders;
use App\Console\Commands\ReleaseSellerSettlements;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )->withCommands([
        AutoSettleOrders::class,
        ReleaseSellerSettlements::class
    ])
    ->withMiddleware(function (Middleware $middleware) {
        // Register aliases
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'seller.auth' => \App\Http\Middleware\SellerAuth::class,
            'auth.customer' => \App\Http\Middleware\CustomerAuth::class,
            'store.status' => \App\Http\Middleware\CheckStoreStatus::class,
            'verify.admin.session' => \App\Http\Middleware\VerifyAdminSession::class,
            'admin.timeout' => \App\Http\Middleware\AdminSessionTimeout::class,
        ]);

        // APPLY MAINTENANCE MIDDLEWARE TO ALL WEB ROUTES
        $middleware->append(\App\Http\Middleware\CheckStoreStatus::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
