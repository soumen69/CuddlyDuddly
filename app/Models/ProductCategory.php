<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];
    
    public $timestamps = false;

    protected $casts = [
        'status' => 'boolean',
    ];

    /* ================= RELATIONS ================= */

    public function subCategories(): HasMany
    {
        return $this->hasMany(ProductSubCategory::class, 'product_categories_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'product_categories_id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductCategoryAttribute::class, 'product_categories_id');
    }

    /* ================= SCOPES ================= */

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
