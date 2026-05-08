<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategorySection extends Model
{
    use HasFactory;

    protected $table = 'product_category_section';

    protected $fillable = [
        'product_id',
        'master_category_section_id',
    ];

    // ↙ Belongs to product
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    // ↙ Belongs to master category section pivot
    public function masterCategorySection()
    {
        return $this->belongsTo(MasterCategorySection::class, 'master_category_section_id');
    }

    // ↙ Shortcut to MasterCategory
    public function masterCategory()
    {
        return $this->hasOneThrough(
            MasterCategory::class,
            MasterCategorySection::class,
            'id',
            'id',
            'master_category_section_id',
            'master_category_id'
        );
    }

    // ↙ Shortcut to SectionType
    public function sectionType()
    {
        return $this->hasOneThrough(
            SectionType::class,
            MasterCategorySection::class,
            'id',
            'id',
            'master_category_section_id',
            'section_type_id'
        );
    }

    // ↙ Shortcut to Category
    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            MasterCategorySection::class,
            'id',
            'id',
            'master_category_section_id',
            'category_id'
        );
    }
}
