<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyAdminSession
{
    public function handle(Request $request, Closure $next)
    {
        $admin = auth('admin')->user();

        if ($admin) {
            $allowMultiple = \App\Models\Setting::getValue('allow_multiple_admin_logins', '0');

            if ($allowMultiple !== '1') {
                // if current browser's session ID differs from the latest stored one
                if ($admin->session_id !== session()->getId()) {
                    auth('admin')->logout();

                    return redirect()
                        ->route('admin.login')
                        ->with('error', 'You were logged in from another device.');
                }
            }
        }

        return $next($request);
    }
}
