<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'provider',
        'awb_number',
        'shipment_id',
        'status',
        'delivered_at',
        'rto_initiated_at',
        'rto_delivered_at',
        'settlement_status',
        'hold_until',
        'payload_last'
    ];

    protected $casts = [
        'payload_last' => 'array',
        'delivered_at' => 'datetime',
        'rto_initiated_at' => 'datetime',
        'rto_delivered_at' => 'datetime',
        'hold_until' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shipmentLogs()
    {
        return $this->hasMany(ShippingLog::class, 'order_id', 'order_id')
            ->orderBy('id', 'desc');
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
}
