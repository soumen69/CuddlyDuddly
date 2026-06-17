<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerSupplierDetail extends Model
{
    protected $fillable = [
        'seller_id',
        'product_categories',
        'monthly_order_capacity',
        'average_dispatch_time'
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }
}
