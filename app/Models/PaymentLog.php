<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = [
        'event',
        'payload',
        'source',
    ];

    protected $casts = [
        'payload' => 'array'
    ];
}
