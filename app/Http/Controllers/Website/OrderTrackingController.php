<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Order\OrderTimelineService;

class OrderTrackingController extends Controller
{
    public function __construct(
        protected OrderTimelineService $timeline
    ) {}

    public function show(
        Order $order
    ) {

        abort_unless(
            $order->user_id === auth('customer')->id(),
            403
        );

        return response()->json([

            'order' => $order->load([
                'items.product.primaryImage',
                'shipments',
            ]),

            'timeline' => $this->timeline->build($order),

        ]);
    }
}
