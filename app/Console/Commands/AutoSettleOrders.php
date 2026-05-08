<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Services\Payment\RazorpayRouteService;

class AutoSettleOrders extends Command
{
    protected $signature = 'orders:auto-settle';
    protected $description = 'Automatically settle orders after hold period';

    public function handle(RazorpayRouteService $service)
    {
        $orders = Order::where('settlement_status', 'on_hold')
            ->where('hold_until', '<=', now())
            ->where('refund_status', '!=', 'refunded')
            ->get();

        foreach ($orders as $order) {
            $service->settle($order);
        }

        $this->info("Settlement completed for {$orders->count()} orders.");
    }
}
