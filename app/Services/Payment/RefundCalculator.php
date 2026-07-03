<?php

namespace App\Services\Payment;

use App\Models\OrderItem;

class RefundCalculator
{
    public function calculate(
        OrderItem $item
    ): float {

        $subtotal = (float) $item->subtotal;

        /*
         Future:
            Coupon Distribution
            Shipping Distribution
            Platform Fees
            GST
            Partial Refund
        */

        return round(
            $subtotal,
            2
        );
    }
}
