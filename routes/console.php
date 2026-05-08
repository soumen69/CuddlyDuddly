<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use App\Console\Commands\AutoSettleOrders;

// Schedule the command
Schedule::command(AutoSettleOrders::class)->dailyAt('02:00');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
});
