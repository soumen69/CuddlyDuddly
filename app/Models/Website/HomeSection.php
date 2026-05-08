<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $table = 'home_sections';

    protected $fillable = [
        'key',
        'data',
        'position',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Scope: only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordered by position
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }
}
