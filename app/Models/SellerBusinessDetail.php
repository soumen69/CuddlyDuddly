<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerBusinessDetail extends Model
{
    protected $fillable = [
        'seller_id',
        'legal_business_name',
        'store_display_name',
        'business_type',
        'gst_available',
        'gst_number',
        'pan_number',
        'pan_name'
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }
}
