<?php

namespace App\Domain\Catalog\Navigation\Repositories;

use App\Models\NavigationMasterCategoryMapping;

class MasterCategoryMappingRepository
{
    public function findMatches(
        ?int $categoryId,
        ?int $subCategoryId
    ) {

        return NavigationMasterCategoryMapping::query()

            ->with([
                'masterCategory:id,name,slug',
            ])

            ->where(function ($query) use (
                $categoryId,
                $subCategoryId
            ) {

                if ($subCategoryId) {

                    $query->orWhere(
                        'product_sub_category_id',
                        $subCategoryId
                    );
                }

                if ($categoryId) {

                    $query->orWhere(
                        'product_category_id',
                        $categoryId
                    );
                }
            })

            ->orderByDesc('priority')

            ->get();
    }
}
