<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerAddress extends Model
{
    protected $fillable = [
        'seller_id',
        'email',
        'city',
        'state',
        'district',
        'pincode',
        'building_number',
        'street'
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }
}
