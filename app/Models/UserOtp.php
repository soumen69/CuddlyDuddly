<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    protected $fillable = [
        'identifier',
        'otp',
        'expires_at',
        'attempts'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];
}
