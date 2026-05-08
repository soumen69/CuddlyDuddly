<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'product_id',
        'seller_id',
        'sku',
        'quantity',
        'reserved_quantity',
        'warehouse_location',
        'price',
        'cost_price',
        'min_stock',
        'status',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($inventory) {
            // If SKU not provided, auto-generate one
            if (empty($inventory->sku)) {
                // Get product and seller names (fallback if not loaded)
                $productName = optional($inventory->product)->name ?? 'PRD';
                $sellerName  = optional($inventory->seller)->name ?? 'SLR';

                // Convert names into short codes
                $productCode = strtoupper(Str::slug(Str::limit($productName, 6, ''), ''));
                $sellerCode  = strtoupper(Str::slug(Str::limit($sellerName, 4, ''), ''));

                // Generate SKU like PRD-SLR-UNIQUE
                $inventory->sku = $productCode . '-' . $sellerCode . '-' . strtoupper(Str::random(5));
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }

    public function logs()
    {
        return $this->hasMany(InventoryLog::class);
    }
}
