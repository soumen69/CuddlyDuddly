<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReplacement extends Model
{
    protected $table = 'order_replacements';

    protected $fillable = [
        'replacement_number',
        'order_id',
        'order_item_id',
        'shipment_id',
        'seller_id',
        'user_id',
        'reviewed_by',
        'reason',
        'review_notes',
        'status',
        'replacement_order_item_id',
        'replacement_shipment_id',
        'approved_at',
        'rejected_at',
        'completed_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

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

    public function replacementItem()
    {
        return $this->belongsTo(
            OrderItem::class,
            'replacement_order_item_id'
        );
    }

    public function shipment()
    {
        return $this->belongsTo(
            Shipment::class
        );
    }

    public function replacementShipment()
    {
        return $this->belongsTo(
            Shipment::class,
            'replacement_shipment_id'
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

    public function isPending(): bool
    {
        return $this->status === 'requested';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
