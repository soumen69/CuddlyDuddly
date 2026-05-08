<?php

namespace App\Services;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class CategoryFilterService
{
    public function getFilters(int $classifiedId, int $masterCategorySectionId): array
    {
        $classified = ProductCategory::with('attributes.attribute')
            ->findOrFail($classifiedId);

        $filters = [];

        foreach ($classified->attributes as $mapping) {

            $attribute = $mapping->attribute;

            if (!$attribute || !$attribute->is_filterable || !$attribute->status) {
                continue;
            }

            $values = $this->getAttributeValues(
                $classifiedId,
                $masterCategorySectionId,
                $attribute->id,
                $attribute->is_variant
            );

            if ($values->isEmpty()) {
                continue;
            }

            $filters[] = [
                'attribute_id' => $attribute->id,
                'name'         => $attribute->name,
                'slug'         => $attribute->slug,
                'input_type'   => $attribute->input_type,
                'values'       => $values,
            ];
        }

        return $filters;
    }

    protected function getAttributeValues(
        int $classifiedId,
        int $masterCategorySectionId,
        int $attributeId,
        bool $isVariant
    ) {

        if ($isVariant) {

            return DB::table('variant_attribute_values as vav')
                ->join('attribute_values as av', 'av.id', '=', 'vav.attribute_value_id')
                ->join('product_variants as pv', 'pv.id', '=', 'vav.variant_id')
                ->join('products as p', 'p.id', '=', 'pv.product_id')
                ->join('product_category_section as pcs', 'pcs.product_id', '=', 'p.id')

                ->where('pcs.master_category_section_id', $masterCategorySectionId)
                ->where('p.product_categories_id', $classifiedId)
                ->where('p.status', 1)
                ->where('p.is_approved', 1)
                ->where('av.attribute_id', $attributeId)

                ->select(
                    'av.id',
                    'av.value',
                    DB::raw('COUNT(DISTINCT p.id) as count')
                )

                ->groupBy('av.id', 'av.value')
                ->orderBy('av.sort_order')
                ->get();
        }

        return DB::table('product_attribute_values as pav')
            ->join('attribute_values as av', 'av.id', '=', 'pav.attribute_value_id')
            ->join('products as p', 'p.id', '=', 'pav.product_id')
            ->join('product_category_section as pcs', 'pcs.product_id', '=', 'p.id')

            ->where('pcs.master_category_section_id', $masterCategorySectionId)
            ->where('p.product_categories_id', $classifiedId)
            ->where('p.status', 1)
            ->where('p.is_approved', 1)
            ->where('av.attribute_id', $attributeId)

            ->select(
                'av.id',
                'av.value',
                DB::raw('COUNT(DISTINCT p.id) as count')
            )

            ->groupBy('av.id', 'av.value')
            ->orderBy('av.sort_order')
            ->get();
    }
}
