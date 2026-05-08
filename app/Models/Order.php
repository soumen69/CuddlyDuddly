<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shipping_address_id',
        'order_number',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'notes'
    ];

    protected $casts = [
        'hold_until'     => 'datetime',
        'delivered_at'   => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    public function shipmentLogs()
    {
        return $this->hasMany(ShippingLog::class, 'order_id');
    }
    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItem::class, 'order_id');
    // }

    // Order has many Products through OrderItems
    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_items', 'order_id', 'product_id');
    }
}