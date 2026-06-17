<?php

namespace App\Services\Seller;

use App\Models\Products;
use App\Models\OrderItem;


class SellerDashboardService
{
    public function getData($sellerId)
    {
        $totalProduct = Products::where('seller_id', $sellerId)->count();
        $totalOrder = OrderItem::whereHas('product', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        })->count();

        $totalEarning = OrderItem::whereHas('product', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        })->sum('price');

        $recentOrders = OrderItem::with('product', 'order')
            ->whereHas('product', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })->latest()->take(10)->get();

        return [
            'totalProducts' => $totalProduct,
            'totalOrders' => $totalOrder,
            'totalEarning' => $totalEarning,
            'recentOrders' => $recentOrders,
        ];
    }

}


?>