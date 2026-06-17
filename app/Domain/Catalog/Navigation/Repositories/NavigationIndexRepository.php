<?php

namespace App\Domain\Catalog\Navigation\Repositories;

use App\Domain\Catalog\Navigation\Contracts\NavigationIndexRepositoryInterface;
use App\Models\MasterCategorySection;
use Illuminate\Support\Facades\Cache;

class NavigationIndexRepository implements NavigationIndexRepositoryInterface
{
    private const CACHE_KEY = 'navigation.index';

    public function all(): array
    {
        return Cache::rememberForever(
            self::CACHE_KEY,
            function () {
                return MasterCategorySection::query()
                    ->with([
                        'masterCategory:id,name,slug',
                        'sectionType:id,name,slug',
                        'category:id,name,slug',
                    ])
                    ->get()
                    ->map(function (MasterCategorySection $row) {
                        return [
                            'master_category_section_id' => (int) $row->id,

                            'master_category_id' => (int) $row->master_category_id,
                            'master_category_name' => $row->masterCategory?->name,
                            'master_category_slug' => $row->masterCategory?->slug,

                            'section_type_id' => (int) $row->section_type_id,
                            'section_type_name' => $row->sectionType?->name,
                            'section_type_slug' => $row->sectionType?->slug,

                            'category_id' => (int) $row->category_id,
                            'category_name' => $row->category?->name,
                            'category_slug' => $row->category?->slug,
                        ];
                    })
                    ->values()
                    ->all();
            }
        );
    }
}
