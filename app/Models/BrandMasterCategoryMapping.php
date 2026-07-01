<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandMasterCategoryMapping extends Model
{
    protected $table =
    'brand_master_category_mappings';

    protected $fillable = [
        'brand_id',
        'master_category_id',
        'priority',
    ];

    public function brand()
    {
        return $this->belongsTo(
            Brands::class,
            'brand_id'
        );
    }

    public function masterCategory()
    {
        return $this->belongsTo(
            MasterCategory::class,
            'master_category_id'
        );
    }
}
