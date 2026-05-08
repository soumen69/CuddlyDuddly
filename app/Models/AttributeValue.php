<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeValue extends Model
{
    protected $fillable = [
        'attribute_id',
        'value',
        'slug',
        'sort_order',
    ];
    public $timestamps = false;

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function variantValues(): HasMany
    {
        return $this->hasMany(VariantAttributeValue::class);
    }

    public function productValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function images()
    {
        return $this->hasMany(ProductAttributeValueImage::class, 'attribute_value_id');
    }
}
