<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\RequestCancellationRequest;
use App\Http\Requests\Order\RequestReplacementRequest;
use App\Http\Requests\Order\RequestReturnRequest;
use App\Models\OrderItem;
use App\Services\Order\OrderLifecycleService;
use Illuminate\Http\JsonResponse;

class OrderLifecycleController extends Controller
{
    public function __construct(
        protected OrderLifecycleService $lifecycle
    ) {}

    public function cancelItem(
        RequestCancellationRequest $request,
        OrderItem $item
    ): JsonResponse {

        $this->authorizeCustomer($item);

        $cancellation = $this->lifecycle->requestCancellation(
            $item,
            $request->reason
        );

        return response()->json([
            'success' => true,
            'message' => 'Cancellation request submitted.',
            'data' => $cancellation,
        ]);
    }

    public function returnItem(
        RequestReturnRequest $request,
        OrderItem $item
    ): JsonResponse {

        $this->authorizeCustomer($item);

        $return = $this->lifecycle->requestReturn(
            $item,
            $request->reason
        );

        return response()->json([
            'success' => true,
            'message' => 'Return request submitted.',
            'data' => $return,
        ]);
    }

    public function replaceItem(
        RequestReplacementRequest $request,
        OrderItem $item
    ): JsonResponse {

        $this->authorizeCustomer($item);

        $replacement = $this->lifecycle->requestReplacement(
            $item,
            $request->reason
        );

        return response()->json([
            'success' => true,
            'message' => 'Replacement request submitted.',
            'data' => $replacement,
        ]);
    }

    protected function authorizeCustomer(
        OrderItem $item
    ): void {

        abort_unless(
            auth('customer')->check(),
            401
        );

        abort_unless(
            $item->order->user_id === auth('customer')->id(),
            403
        );
    }
}
