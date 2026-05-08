<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementsLog extends Model
{
    protected $table = 'settlements_log';

    protected $fillable = [
        'settlement_batch_id',
        'total_settlement_amount',
        'total_commission',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array'
    ];
}
