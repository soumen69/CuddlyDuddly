<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];


    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * SectionType → MasterCategories
     */
    public function masterCategories()
    {
        return $this->belongsToMany(
            MasterCategory::class,
            'master_category_sections',
            'section_type_id',
            'master_category_id'
        )->distinct();
    }

    /**
     * SectionType → Categories
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'master_category_sections',
            'section_type_id',
            'category_id'
        )
            ->withPivot(['master_category_id'])
            ->distinct();
    }
}
