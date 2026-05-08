<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class CheckStoreStatus
{
    public function handle(Request $request, Closure $next)
    {
        $storeStatus   = Setting::getValue('store_status', 'active'); // active | full_maintenance
        $frontendMode  = Setting::getValue('frontend_maintenance', 'active'); // active | maintenance
        $sellerMode    = Setting::getValue('seller_maintenance', 'active'); // active | maintenance
        $message       = Setting::getValue('maintenance_message');

        // 🚨 Allow Admin Panel regardless of maintenance status
        if (
            $request->is('admin') ||
            $request->is('admin/*') ||
            $request->routeIs('admin.*')
        ) {
            return $next($request);
        }

        // 🌐 Full maintenance → block everyone except admin
        if ($storeStatus === 'full_maintenance') {
            return response()->view('maintenance', ['message' => $message], 503);
        }

        // 🛒 Frontend maintenance only
        if ($frontendMode === 'maintenance') {

            // user is accessing frontend (NOT seller)
            if (
                !$request->is('seller') &&
                !$request->is('seller/*') &&
                !$request->routeIs('seller.*')
            ) {
                return response()->view('maintenance', ['message' => $message], 503);
            }
        }

        // 🧾 Seller portal maintenance only
        if ($sellerMode === 'maintenance') {
            if ($request->is('seller') || $request->is('seller/*') || $request->routeIs('seller.*')) {
                return response()->view('maintenance', ['message' => $message], 503);
            }
        }

        return $next($request);
    }
}
