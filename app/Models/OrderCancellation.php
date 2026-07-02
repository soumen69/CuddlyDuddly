<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCancellation extends Model
{
    protected $table = 'order_cancellations';

    protected $fillable = [
        'cancel_number',
        'order_id',
        'order_item_id',
        'shipment_id',
        'seller_id',
        'user_id',
        'cancelled_by',
        'reason',
        'status',
        'approved_by',
        'approved_at',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
        'refund_amount',
        'refund_status',
        'razorpay_refund_id',
        'cancelled_at',
        'completed_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'refund_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
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

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function isPending(): bool
    {
        return $this->status === 'requested';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
