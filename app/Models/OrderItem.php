<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [

        'order_id',
        'seller_id',
        'shipment_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
        'subtotal',
        'commission_percent',
        'commission_amount',
        'commission_snapshot',
        'seller_amount',
        'settlement_status',
        'item_status',
        'return_status',
        'replacement_status',
        'cancellation_status',
        'delivered_at',
        'cancelled_at',
        'returned_at',
        'metadata'
    ];

    protected $casts = [
        'commission_amount' => 'float',
        'seller_amount'     => 'float',
        'subtotal'          => 'float',
        'commission_percent' => 'float',
        'metadata' => 'array',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'returned_at' => 'datetime',
    ];


    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    // ============================= RELATIONS =============================

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(
            ProductVariant::class,
            'product_variant_id'
        );
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

    public function cancellations()
    {
        return $this->hasMany(
            OrderCancellation::class
        );
    }

    public function returns()
    {
        return $this->hasMany(
            OrderReturn::class
        );
    }

    public function replacements()
    {
        return $this->hasMany(
            OrderReplacement::class
        );
    }
}
