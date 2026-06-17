<?php

namespace App\Http\Controllers\Seller;

use App\Models\Sellers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Seller\SellerDashboardService;
use Illuminate\Support\Facades\DB;

class SellerDashboardController extends Controller
{
    public function index(Sellers $seller, SellerDashboardService $sellerDashboardService)
    {
        $sellerUser = Auth::guard('seller')->user();
        if (
            !$sellerUser ||
            (
                (int) $sellerUser->id !== (int) $seller->id &&
                (
                    empty($sellerUser->auth_id) ||
                    (int) $sellerUser->auth_id !== (int) $seller->auth_id
                )
            )
        ) {
            abort(403);
        }

        $data = $sellerDashboardService->getData($seller->id);
        $hasBulkActivity = DB::table('ingestion_batches')
            ->where('seller_id', $seller->id)
            ->exists();
        return view('seller.dashboard', array_merge(['seller' => $sellerUser], $data), compact('hasBulkActivity'));
    }
}
