<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingLog extends Model
{
    protected $table = 'shipping_logs';

    protected $fillable = [
        'shipment_id',
        'order_id',
        'provider',
        'event_name',
        'provider_status',
        'internal_status',
        'location',
        'remarks',
        'event_time',
        'payload'
    ];

    protected $casts = [
        'payload' => 'array',
        'event_time' => 'datetime'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
