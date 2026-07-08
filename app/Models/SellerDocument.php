<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerDocument extends Model
{
    protected $fillable = [
        'seller_id',
        'document_type',
        'file_path',
        'status',
        'remarks',
    ];

    public function seller()
    {
        return $this->belongsTo(Sellers::class);
    }
}