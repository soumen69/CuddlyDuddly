<?php

namespace App\Services\Payment\Contracts;

use App\Models\Order;
use App\Models\OrderItem;

interface RefundProvider
{
    public function refund(
        Order $order,
        OrderItem $item,
        float $amount,
        string $reason = ''
    ): array;
}
