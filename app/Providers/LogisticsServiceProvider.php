<?php

namespace App\Providers;

use App\Services\Logistics\Contracts\CourierProvider;
use App\Services\Logistics\Providers\MockCourierProvider;
use App\Services\Logistics\Providers\ShiprocketProvider;
use Illuminate\Support\ServiceProvider;

class LogisticsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            CourierProvider::class,
            function () {

                return match (config('logistics.provider')) {

                    'shiprocket' =>
                    new ShiprocketProvider(),

                    default =>
                    new MockCourierProvider(),
                };
            }
        );
    }

    public function boot(): void {}
}
