<?php

namespace App\Domain\Catalog\Navigation\Services;

use App\Models\Brands;
use App\Models\Category;
use App\Models\MasterCategorySection;
use App\Models\BrandMasterCategoryMapping;
use Illuminate\Support\Facades\DB;

class BrandHierarchySynchronizer
{
    public function sync(
        Brands $brand
    ): void {

        DB::transaction(function () use ($brand) {

            /*
            |--------------------------------------------------------------------------
            | Brand → Navigation Category
            |--------------------------------------------------------------------------
            */

            $existingMapping = DB::table(
                'brand_navigation_categories'
            )
                ->where(
                    'brand_id',
                    $brand->id
                )
                ->first();

            $category = null;

            if ($existingMapping) {

                $category = Category::find(
                    $existingMapping->category_id
                );
            }

            if (! $category) {

                $category = Category::create([
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                ]);
            }

            DB::table(
                'brand_navigation_categories'
            )->updateOrInsert(
                [
                    'brand_id' => $brand->id,
                ],
                [
                    'category_id' => $category->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Allowed Master Categories
            |--------------------------------------------------------------------------
            */

            $masterCategoryIds =
                BrandMasterCategoryMapping::query()

                ->where(
                    'brand_id',
                    $brand->id
                )

                ->pluck(
                    'master_category_id'
                )

                ->all();

            if (empty($masterCategoryIds)) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Inject Into Existing Brand Section
            |--------------------------------------------------------------------------
            */

            foreach ($masterCategoryIds as $masterCategoryId) {

                $brandSection = MasterCategorySection::query()

                    ->join(
                        'section_types',
                        'section_types.id',
                        '=',
                        'master_category_sections.section_type_id'
                    )

                    ->where(
                        'master_category_sections.master_category_id',
                        $masterCategoryId
                    )

                    ->where(
                        'section_types.name',
                        'LIKE',
                        '%BRAND%'
                    )

                    ->select(
                        'master_category_sections.section_type_id'
                    )

                    ->distinct()

                    ->first();

                if (! $brandSection) {
                    continue;
                }

                MasterCategorySection::firstOrCreate(
                    [
                        'master_category_id' =>
                        $masterCategoryId,

                        'section_type_id' =>
                        $brandSection->section_type_id,

                        'category_id' =>
                        $category->id,
                    ]
                );
            }
        });
    }
}
