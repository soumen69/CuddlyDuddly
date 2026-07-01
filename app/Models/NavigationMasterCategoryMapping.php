<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationMasterCategoryMapping extends Model
{
    protected $fillable = [
        'product_category_id',
        'product_sub_category_id',
        'master_category_id',
        'priority',
    ];

    public function masterCategory()
    {
        return $this->belongsTo(
            MasterCategory::class,
            'master_category_id'
        );
    }

    public function productCategory()
    {
        return $this->belongsTo(
            ProductCategory::class,
            'product_category_id'
        );
    }

    public function productSubCategory()
    {
        return $this->belongsTo(
            ProductSubCategory::class,
            'product_sub_category_id'
        );
    }
}
