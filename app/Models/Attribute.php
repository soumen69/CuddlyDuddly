<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'input_type',
        'is_filterable',
        'is_variant',
        'is_visual',
        'status',
    ];
    public $timestamps = false;

    protected $casts = [
        'is_filterable' => 'boolean',
        'is_variant'    => 'boolean',
        'status'        => 'boolean',
    ];

    /* ================= RELATIONS ================= */

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function categoryMappings(): HasMany
    {
        return $this->hasMany(ProductCategoryAttribute::class);
    }

    /* ================= SCOPES ================= */

    public function scopeFilterable($query)
    {
        return $query->where('is_filterable', true);
    }

    public function scopeVariant($query)
    {
        return $query->where('is_variant', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function categories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'product_category_attributes',
            'attribute_id',
            'product_categories_id'
        );
    }
}
