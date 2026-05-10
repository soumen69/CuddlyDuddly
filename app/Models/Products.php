<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory;

    protected $guard = 'seller';
    protected $table = "products";

    protected $fillable = [
        'product_code',
        'product_categories_id',
        'product_sub_categories_id',
        'seller_id',
        'bulk_batch_id',
        'name',
        'short_description',
        'slug',
        'description',
        'brand_id',
        'auto_sku',
        'sku',
        'price',
        'discount_price',
        'stock',
        'youtube_url',
        'is_approved',
        'approved_by',
        'approved_at',
        'commission_percent',
        'cancellation_policy',
        'featured',
        'status',
        'image_upload_status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . uniqid();
            }
        });
    }
    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id')
            ->where('is_active', 1);
    }

    // Product belongs to a seller
    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    // Product can have many images
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // Get primary image of the product
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id')->where('is_primary', 1);
    }

    public function visualImages()
    {
        return $this->hasMany(ProductAttributeValueImage::class, 'product_id');
    }


    public function primaryVariantImage()
    {
        return $this->hasOne(ProductAttributeValueImage::class, 'product_id')
            ->where('is_primary', 1)
            ->latest('id'); // or latest('created_at')
    }

    // Product can have many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    // Product approved by admin
    public function approvedBy()
    {
        return $this->belongsTo(AdminUser::class, 'approved_by');
    }

    // 🔍 Scopes
    public function scopeApprovedAndFeatured($query)
    {
        return $query->where('is_approved', 1)
            ->where('featured', 1)
            ->where('status', 1);
    }

    public function categoryChain()
    {
        return $this->hasOne(ProductCategorySection::class, 'product_id');
    }

    public function categorySections()
    {
        return $this->hasMany(ProductCategorySection::class, 'product_id');
    }

    public function orders()
    {
        // Many-to-Many: products <-> orders via order_items
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id')
            ->with(['attributeValue.attribute']);
    }

    public function attributes()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_attribute_values',
            'product_id',
            'attribute_value_id'
        );
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(ProductSubCategory::class, 'product_sub_categories_id');
    }

    public function visualAttributeImages()
    {
        return $this->hasMany(ProductAttributeValueImage::class, 'product_id');
    }
}
