<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerPickupAddress extends Model
{
    protected $fillable = [
        'seller_id',
        'pickup_address_line1',
        'pickup_address_line2',
        'pickup_city',
        'pickup_state',
        'pickup_pincode',
        'pickup_landmark',
        'contact_person_name',
        'contact_mobile',
        'alternate_mobile'
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }
}
