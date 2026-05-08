<?php

namespace App\Services;

use App\Models\Products;
use App\Models\ProductVariant;

class CartService
{
    public function getCart()
    {
        return session()->get('cart', []);
    }

    // 🔥 NEW: Get full cart with product data
    public function get()
    {
        $cart = $this->getCart();
        if (empty($cart)) return [];
        $items = [];
        foreach ($cart as $item) {
            $product = Products::with('images')->find($item['product_id']);
            if (!$product) continue;
            $variant = null;
            if ($item['variant_id']) {
                $variant = ProductVariant::find($item['variant_id']);
            }
            $price = $variant?->price ?? $product->price;
            $items[] = (object)[
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name' => $product->name,
                'image' => optional($product->images->first())->image_path ?? 'fallback.png',
                'price' => $price,
                'qty' => $item['qty'],
                'product' => $product,
                'variant' => $variant,
            ];
        }
        return $items;
    }

    public function add($productId, $variantId, $qty = 1)
    {
        $cart = $this->getCart();

        foreach ($cart as &$item) {
            if (
                $item['product_id'] == $productId &&
                $item['variant_id'] == $variantId
            ) {
                $item['qty'] += $qty;
                session()->put('cart', $cart);
                return;
            }
        }

        $cart[] = [
            'product_id' => $productId,
            'variant_id' => $variantId,
            'qty' => $qty
        ];

        session()->put('cart', $cart);
    }

    public function clear()
    {
        session()->forget('cart');
    }
}
