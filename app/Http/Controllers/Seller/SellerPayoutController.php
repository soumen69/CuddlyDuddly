<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerPayoutController extends Controller
{
    public function index()
    {
        $seller = auth('seller')->user();
        return view('seller.payout.index', compact('seller'));
    }
}
