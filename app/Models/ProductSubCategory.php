<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSubCategory extends Model
{
    protected $fillable = [
        'product_categories_id',
        'name',
        'slug',
        'status',
    ];
    public $timestamps = false;

    protected $casts = [
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }
}
