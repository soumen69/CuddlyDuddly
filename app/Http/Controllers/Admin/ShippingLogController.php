<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingLog;
use Illuminate\Http\Request;

class ShippingLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ShippingLog::latest()->paginate(50);

        return view('admin.shippinglogs.index', compact('logs'));
    }
}
