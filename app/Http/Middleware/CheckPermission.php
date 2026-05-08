<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
