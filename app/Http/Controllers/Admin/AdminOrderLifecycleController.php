<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderCancellation;
use App\Models\OrderReturn;
use App\Models\OrderReplacement;
use App\Models\Shipment;
use App\Services\Order\OrderLifecycleService;
use App\Services\Order\OrderStatusEngine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminOrderLifecycleController extends Controller
{
    public function __construct(
        protected OrderLifecycleService $lifecycle,
        protected OrderStatusEngine $statusEngine
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Cancellation
    |--------------------------------------------------------------------------
    */

    public function approveCancellation(
        Request $request,
        OrderCancellation $cancellation
    ): JsonResponse {

        $record = $this->lifecycle->approveCancellation(
            $cancellation,
            auth('admin')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Cancellation approved.',
            'data' => $record,
        ]);
    }

    public function rejectCancellation(
        Request $request,
        OrderCancellation $cancellation
    ): JsonResponse {

        $record = $this->lifecycle->rejectCancellation(
            $cancellation,
            auth('admin')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Cancellation rejected.',
            'data' => $record,
        ]);
    }

    public function completeCancellation(
        OrderCancellation $cancellation
    ): JsonResponse {

        $record = $this->lifecycle->completeCancellation(
            $cancellation
        );

        return response()->json([
            'success' => true,
            'message' => 'Cancellation completed.',
            'data' => $record,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Returns
    |--------------------------------------------------------------------------
    */

    public function approveReturn(
        Request $request,
        OrderReturn $return
    ): JsonResponse {

        $record = $this->lifecycle->approveReturn(
            $return,
            auth('admin')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Return approved.',
            'data' => $record,
        ]);
    }

    public function rejectReturn(
        Request $request,
        OrderReturn $return
    ): JsonResponse {

        $record = $this->lifecycle->rejectReturn(
            $return,
            auth('admin')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Return rejected.',
            'data' => $record,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Replacement
    |--------------------------------------------------------------------------
    */

    public function approveReplacement(
        Request $request,
        OrderReplacement $replacement
    ): JsonResponse {

        $record = $this->lifecycle->approveReplacement(
            $replacement,
            auth('admin')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Replacement approved.',
            'data' => $record,
        ]);
    }

    public function rejectReplacement(
        Request $request,
        OrderReplacement $replacement
    ): JsonResponse {

        $record = $this->lifecycle->rejectReplacement(
            $replacement,
            auth('admin')->id(),
            $request->input('notes')
        );

        return response()->json([
            'success' => true,
            'message' => 'Replacement rejected.',
            'data' => $record,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Shipment Override
    |--------------------------------------------------------------------------
    */

    public function forceShipmentStatus(
        Request $request,
        Shipment $shipment
    ): JsonResponse {

        $request->validate([
            'status' => [
                'required',
                'string',
            ],
        ]);

        $shipment = $this->statusEngine->forceStatus(
            $shipment,
            $request->status,
            [
                'provider_status' => 'Admin Override',
                'remarks' => $request->input('remarks'),
                'updated_by' => auth('admin')->id(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Shipment updated.',
            'data' => $shipment,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Settlement
    |--------------------------------------------------------------------------
    */

    public function releaseSettlement(
        Shipment $shipment
    ): JsonResponse {

        $shipment = $this->statusEngine->updateShipmentStatus(
            $shipment,
            'delivered',
            [
                'provider_status' => 'Manual Settlement',
                'released_by' => auth('admin')->id(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Settlement processed.',
            'data' => $shipment,
        ]);
    }
}
