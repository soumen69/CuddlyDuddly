<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Catalog\Navigation\Services\BrandHierarchySynchronizer;

class Brands extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    protected static function booted()
    {
        static::saved(function (
            Brands $brand
        ) {
            app(
                BrandHierarchySynchronizer::class
            )->sync($brand);
        });
    }
}
