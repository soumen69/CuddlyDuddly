<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettlementsLog;
use Illuminate\Http\Request;

class SettlementLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = SettlementsLog::latest()->paginate(30);

        return view('admin.settlements.index', compact('logs'));
    }
}
