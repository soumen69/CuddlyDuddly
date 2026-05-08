<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentLog;
use Illuminate\Http\Request;

class PaymentLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = PaymentLog::latest()->paginate(50);

        return view('admin.paymentlogs.index', compact('logs'));
    }
}
