<?php

namespace App\Domain\Catalog\Navigation\Repositories;

use App\Domain\Catalog\Navigation\Contracts\ProductCategorySectionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductCategorySectionRepository implements ProductCategorySectionRepositoryInterface
{
    public function replace(
        int $productId,
        array $masterCategorySectionIds
    ): void {
        $masterCategorySectionIds = array_values(
            array_unique(
                array_filter($masterCategorySectionIds)
            )
        );

        DB::transaction(function () use (
            $productId,
            $masterCategorySectionIds
        ) {

            DB::table('product_category_section')
                ->where('product_id', $productId)
                ->delete();

            if (empty($masterCategorySectionIds)) {
                return;
            }

            $rows = [];

            foreach ($masterCategorySectionIds as $id) {

                $rows[] = [
                    'product_id' => $productId,
                    'master_category_section_id' => $id,
                ];
            }

            DB::table('product_category_section')
                ->insert($rows);
        });
    }
}
