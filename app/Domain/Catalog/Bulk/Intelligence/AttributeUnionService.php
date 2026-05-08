<?php

namespace App\Domain\Catalog\Bulk\Intelligence;
use App\Models\ProductCategoryAttribute;

class AttributeUnionService
{
    public function build(array $categoryIds): array
    {
        $mappings = ProductCategoryAttribute::query()
            ->whereIn('product_categories_id', $categoryIds)
            ->with(['attribute.values'])
            ->get();

        $union = [];

        foreach ($mappings as $map) {

            $attr = $map->attribute;

            if (!isset($union[$attr->id])) {

                $union[$attr->id] = [
                    'id' => $attr->id,
                    'name' => $attr->name,
                    'slug' => $attr->slug,
                    'input_type' => $attr->input_type,
                    'is_variant' => $attr->is_variant,
                    'is_visual' => $attr->is_visual,
                    'required_in_categories' => [],
                    'is_required_any' => false,
                    'sort_order_min' => $map->sort_order,
                    'values' => $attr->values->pluck('value', 'id')->toArray(),
                ];
            }

            $union[$attr->id]['required_in_categories'][] = $map->product_categories_id;

            if ($map->is_required) {
                $union[$attr->id]['is_required_any'] = true;
            }

            if ($map->sort_order < $union[$attr->id]['sort_order_min']) {
                $union[$attr->id]['sort_order_min'] = $map->sort_order;
            }
        }

        return $union;
    }
}
