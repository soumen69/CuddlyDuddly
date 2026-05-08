<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'commission_percent',
        'commission_amount',
        'seller_amount',
        'subtotal',
        'settlement_status'
    ];

    protected $casts = [
        'commission_amount' => 'float',
        'seller_amount'     => 'float',
        'subtotal'          => 'float',
        'commission_percent' => 'float',
    ];

    // ============================= RELATIONS =============================

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function seller()
    {
        return $this->hasOneThrough(
            Sellers::class,
            Products::class,
            'id',        // products.id
            'id',        // sellers.id
            'product_id', // order_items.product_id
            'seller_id'  // products.seller_id
        );
    }

    // ============================= HELPERS ================================

    /** Recalculates item totals (used in update/edit processes) */
    public function recalculateTotals()
    {
        if (!$this->product) {
            return;
        }

        $subtotal = $this->product->price * $this->quantity;
        $commission = ($subtotal * $this->commission_percent) / 100;

        $this->update([
            'price'             => $this->product->price,
            'subtotal'          => $subtotal,
            'commission_amount' => $commission,
            'seller_amount'     => $subtotal - $commission,
        ]);
    }
}
