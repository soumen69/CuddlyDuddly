<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'image_url', 'status'];


    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function sectionTypes()
    {
        return $this->hasManyThrough(
            SectionType::class,
            MasterCategorySection::class,
            'master_category_id',
            'id',
            'id',
            'section_type_id'
        )->distinct();
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'master_category_sections',
            'master_category_id',
            'category_id'
        )->withPivot('section_type_id')->distinct();
    }

    /**
     * Build FULL CATEGORY MENU CHAIN
     */
    public static function menuChain()
    {
        return self::with(['sectionTypes', 'categories'])
            ->where('status', 1)
            ->orderBy('id')
            ->get()
            ->map(function ($master) {

                $sections = $master->sectionTypes->map(function ($section) use ($master) {

                    $categories = $master->categories
                        ->where('pivot.section_type_id', $section->id)
                        ->values()
                        ->map(function ($cat) {
                            return [
                                'id'   => $cat->id,
                                'name' => $cat->name,
                                'slug' => $cat->slug,
                            ];
                        });

                    return [
                        'id'         => $section->id,
                        'name'       => strtoupper($section->name),
                        'slug'       => $section->slug,
                        'categories' => $categories,
                    ];
                });

                return [
                    'id'       => $master->id,
                    'name'     => $master->name,
                    'slug'     => $master->slug,
                    'sections' => $sections,
                ];
            });
    }
}
