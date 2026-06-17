<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'receiver_id',
        'receiver_type',
        'title',
        'message',
        'type',
        'image',
        'details',
        'reference_id',
        'is_read',
    ];
}
