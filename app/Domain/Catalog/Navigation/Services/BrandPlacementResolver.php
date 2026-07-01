<?php

namespace App\Domain\Catalog\Navigation\Services;

use Illuminate\Support\Facades\DB;

class BrandPlacementResolver
{
    public function resolve(
        ?int $brandId
    ): array {

        if (! $brandId) {
            return [];
        }

        $categoryId = DB::table(
            'brand_navigation_categories'
        )
            ->where(
                'brand_id',
                $brandId
            )
            ->value(
                'category_id'
            );

        if (! $categoryId) {
            return [];
        }

        return DB::table(
            'master_category_sections'
        )
            ->where(
                'category_id',
                $categoryId
            )
            ->pluck('id')
            ->map(
                fn($id) => (int) $id
            )
            ->all();
    }
}
