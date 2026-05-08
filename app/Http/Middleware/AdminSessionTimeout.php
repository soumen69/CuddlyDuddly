<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class AdminSessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {

            $timeout = (int) Setting::getValue('session_timeout_minutes', 60); // default 60

            $lastActivity = session('last_activity_time');
            $now = time();

            if ($lastActivity && ($now - $lastActivity) > ($timeout * 60)) {
                Auth::guard('admin')->logout();
                session()->forget('last_activity_time');

                return redirect()->route('admin.login')
                    ->with('error', 'You were logged out due to inactivity.');
            }

            session(['last_activity_time' => $now]);
        }

        return $next($request);
    }
}
