<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'compare_price',
        'stock',
        'weight',
        'status',
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'compare_price' => 'decimal:2',
        'stock'         => 'integer',
        'weight'        => 'decimal:2',
        'status'        => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(VariantAttributeValue::class, 'variant_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function values()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'variant_attribute_values',
            'variant_id',
            'attribute_value_id'
        );
    }

    public function variantAttributeValues()
    {
        return $this->hasMany(
            VariantAttributeValue::class,
            'variant_id'
        );
    }

    public function getImagePathAttribute(): ?string
    {
        foreach ($this->variantAttributeValues as $variantAttribute) {

            $image = $variantAttribute->attributeValue?->images
                ->where('product_id', $this->product_id)
                ->where('is_primary', true)
                ->first();

            if ($image) {
                return $image->image_path;
            }
        }

        return $this->product?->primaryImage?->image_path;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : asset('images/product-placeholder.png');
    }
}
