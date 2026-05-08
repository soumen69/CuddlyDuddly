<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingLog extends Model
{
    protected $table = 'shipping_logs';

    protected $fillable = [
        'order_id',
        'event_name',
        'payload'
    ];

    protected $casts = [
        'payload' => 'array'
    ];
}
