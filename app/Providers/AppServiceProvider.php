<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterCategory;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /**
         * Permission directive
         */
        Blade::if('canAccess', function ($permission) {
            $user = Auth::guard('admin')->user();
            if (!$user) return false;

            return method_exists($user, 'hasPermission')
                && $user->hasPermission($permission);
        });

        /**
         * GLOBAL CATEGORY MENU (Mega menu)
         * Injected wherever the partial is used
         */
        View::composer('website.partials.category-menu', function ($view) {
            $view->with(
                'categoryChain',
                MasterCategory::menuChain()
            );
        });

        View::composer('*', function ($view) {
            $count = 0;
            if (auth('customer')->check()) {
                $count = Cart::where('user_id', auth('customer')->id())
                    ->where('is_ordered', false)
                    ->sum('quantity'); // ✅ SUM of qty (CORRECT)
            }
            $view->with('cartCount', $count);
        });
    }
}
