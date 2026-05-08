<?php

namespace App\Services;

use App\Models\ProductCategory;
use App\Models\Products;

class ProductCodeService
{
    public static function generate(int $categoryId): string
    {
        $category = ProductCategory::find($categoryId);
        $prefix = 'CD'; // system prefix
        $catCode = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $category->name), 0, 3));
        $lastId = Products::max('id') + 1;
        $sequence = str_pad($lastId, 8, '0', STR_PAD_LEFT);
        return "{$prefix}-{$catCode}-{$sequence}";
    }
}
