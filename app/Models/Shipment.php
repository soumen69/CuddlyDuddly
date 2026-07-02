<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'seller_id',
        'provider',
        'awb_number',
        'tracking_number',
        'tracking_url',
        'courier_name',
        'courier_code',
        'pickup_token',
        'provider_reference',
        'shipment_id',
        'status',
        'packed_at',
        'picked_up_at',
        'shipped_at',
        'in_transit_at',
        'out_for_delivery_at',
        'expected_delivery',
        'delivered_at',
        'cancelled_at',
        'rto_initiated_at',
        'rto_delivered_at',
        'settlement_status',
        'hold_until',
        'payload_last',
        'provider_metadata'
    ];

    protected $casts = [
        'payload_last' => 'array',
        'provider_metadata' => 'array',
        'packed_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'shipped_at' => 'datetime',
        'in_transit_at' => 'datetime',
        'out_for_delivery_at' => 'datetime',
        'expected_delivery' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'rto_initiated_at' => 'datetime',
        'rto_delivered_at' => 'datetime',
        'hold_until' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function logs()
    {
        return $this->hasMany(
            ShippingLog::class,
            'shipment_id'
        )->latest();
    }

    public function items()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }

    public static function readableStatus($event)
    {
        $map = [
            'AWB Assigned'      => 'AWB assigned to shipment',
            'Pickup Scheduled'  => 'Pickup scheduled by courier',
            'In Transit'        => 'Shipment is in transit',
            'Out For Delivery'  => 'Courier is out for delivery',
            'Delivered'         => 'Shipment delivered successfully',
            'RTO Initiated'     => 'Return to Origin initiated',
            'RTO Delivered'     => 'Shipment returned to origin',
            'Cancelled'         => 'Shipment cancelled',
            'MOCK_AWB_CREATED'  => 'Mock: AWB created',
            'MOCK_DELIVERED'    => 'Mock: Delivered',
        ];

        return $map[$event] ?? ucfirst(strtolower(str_replace('_', ' ', $event)));
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
