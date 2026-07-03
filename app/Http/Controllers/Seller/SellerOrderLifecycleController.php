<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderCancellation;
use App\Models\OrderReplacement;
use App\Models\OrderReturn;
use App\Services\Order\OrderLifecycleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerOrderLifecycleController extends Controller
{
    public function __construct(
        protected OrderLifecycleService $lifecycle
    ) {}

    public function approveCancellation(Request $request, OrderCancellation $cancellation): JsonResponse
    {
        $this->authorizeSeller(
            $cancellation->seller_id
        );

        $record = $this->lifecycle->approveCancellation(
            $cancellation,
            auth('seller')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Cancellation approved.',
            'data' => $record,
        ]);
    }

    public function rejectCancellation(Request $request, OrderCancellation $cancellation): JsonResponse
    {
        $this->authorizeSeller(
            $cancellation->seller_id
        );

        $record = $this->lifecycle->rejectCancellation(
            $cancellation,
            auth('seller')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Cancellation rejected.',
            'data' => $record,
        ]);
    }


    public function approveReturn(Request $request, OrderReturn $return): JsonResponse
    {
        $this->authorizeSeller(
            $return->seller_id
        );

        $record = $this->lifecycle->approveReturn(
            $return,
            auth('seller')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Return approved.',
            'data' => $record,
        ]);
    }

    public function rejectReturn(Request $request, OrderReturn $return): JsonResponse
    {
        $this->authorizeSeller(
            $return->seller_id
        );

        $record = $this->lifecycle->rejectReturn(
            $return,
            auth('seller')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Return rejected.',
            'data' => $record,
        ]);
    }

    public function approveReplacement(Request $request, OrderReplacement $replacement): JsonResponse
    {
        $this->authorizeSeller(
            $replacement->seller_id
        );

        $record = $this->lifecycle->approveReplacement(
            $replacement,
            auth('seller')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Replacement approved.',
            'data' => $record,
        ]);
    }

    public function rejectReplacement(Request $request, OrderReplacement $replacement): JsonResponse
    {
        $this->authorizeSeller(
            $replacement->seller_id
        );

        $record = $this->lifecycle->rejectReplacement(
            $replacement,
            auth('seller')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Replacement rejected.',
            'data' => $record,
        ]);
    }

    protected function authorizeSeller(int $sellerId): void
    {
        abort_unless(
            auth('seller')->check(),
            401
        );

        abort_unless(
            auth('seller')->user()->id === $sellerId,
            403
        );
    }
}
