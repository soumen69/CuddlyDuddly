<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCategoryAttribute extends Model
{
    protected $table = 'product_category_attributes';
    public $timestamps = false;
    protected $fillable = [
        'product_categories_id',
        'attribute_id',
        'is_required',
        'sort_order',
    ];

    protected $casts = [
        'is_required'  => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
