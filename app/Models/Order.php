<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Order\OrderTimelineService;

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

    public function shipments()
    {
        return $this->hasMany(
            Shipment::class,
            'order_id'
        );
    }

    public function shipmentLogs()
    {
        return $this->hasManyThrough(
            ShippingLog::class,
            Shipment::class,
            'order_id',
            'shipment_id',
            'id',
            'id'
        );
    }

    public function logs()
    {
        return $this->hasManyThrough(
            ShippingLog::class,
            Shipment::class,
            'order_id',
            'shipment_id',
            'id',
            'id'
        )->latest();
    }

    public function timeline()
    {
        return app(
            OrderTimelineService::class
        )->build($this);
    }

    // Order has many Products through OrderItems
    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_items', 'order_id', 'product_id');
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
