<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerBankDetail extends Model
{
    protected $fillable = [
        'seller_id',
        'account_holder_name',
        'bank_name',
        'account_number',
        'ifsc_code'
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }
}
