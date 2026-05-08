<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'product_categories_id',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Category → MasterCategories
     */
    public function masterCategories()
    {
        return $this->belongsToMany(
            MasterCategory::class,
            'master_category_sections',
            'category_id',
            'master_category_id'
        )->distinct();
    }

    /**
     * Category → SectionTypes
     */
    public function sectionTypes()
    {
        return $this->belongsToMany(
            SectionType::class,
            'master_category_sections',
            'category_id',
            'section_type_id'
        )->distinct();
    }
}
