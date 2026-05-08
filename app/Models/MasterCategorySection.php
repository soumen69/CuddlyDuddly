<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCategorySection extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'master_category_id',
        'section_type_id',
        'category_id',
    ];

    public function masterCategory()
    {
        return $this->belongsTo(MasterCategory::class);
    }

    public function sectionType()
    {
        return $this->belongsTo(SectionType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(ProductCategorySection::class);
    }

    public static function findByHierarchy($masterId, $sectionId, $categoryId)
    {
        return self::where([
            'master_category_id' => $masterId,
            'section_type_id'    => $sectionId,
            'category_id'        => $categoryId,
        ])->firstOrFail();
    }
}
