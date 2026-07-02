<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    protected $table = 'order_returns';

    protected $fillable = [
        'return_number',
        'order_id',
        'order_item_id',
        'shipment_id',
        'seller_id',
        'user_id',
        'reviewed_by',
        'reason',
        'review_notes',
        'status',
        'refund_amount',
        'refund_status',
        'razorpay_refund_id',
        'pickup_awb',
        'pickup_status',
        'pickup_scheduled_at',
        'picked_up_at',
        'received_at',
        'inspection_status',
        'inspected_at',
        'refunded_at',
        'closed_at',
        'reviewed_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'refund_amount' => 'decimal:2',
        'pickup_scheduled_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'received_at' => 'datetime',
        'inspected_at' => 'datetime',
        'refunded_at' => 'datetime',
        'closed_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(
            OrderItem::class,
            'order_item_id'
        );
    }

    public function shipment()
    {
        return $this->belongsTo(
            Shipment::class
        );
    }

    public function seller()
    {
        return $this->belongsTo(
            Sellers::class
        );
    }

    public function customer()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function reviewer()
    {
        return $this->belongsTo(
            User::class,
            'reviewed_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isRequested(): bool
    {
        return $this->status === 'requested';
    }

    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }
}
