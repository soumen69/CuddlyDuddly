<?php

namespace App\Domain\Catalog\Navigation\Services;

use Illuminate\Support\Facades\DB;

class CategoryPlacementResolver
{
    public function resolve(
        int $masterCategoryId,
        ?int $subCategoryId
    ): array {

        if (! $subCategoryId) {
            return [];
        }

        return DB::table(
            'navigation_category_mappings as ncm'
        )
            ->join(
                'master_category_sections as mcs',
                function ($join) use (
                    $masterCategoryId
                ) {

                    $join->on(
                        'mcs.category_id',
                        '=',
                        'ncm.category_id'
                    )
                        ->where(
                            'mcs.master_category_id',
                            $masterCategoryId
                        );
                }
            )
            ->where(
                'ncm.product_sub_category_id',
                $subCategoryId
            )
            ->pluck(
                'mcs.id'
            )
            ->map(
                fn($id) => (int) $id
            )->all();
    }
}
