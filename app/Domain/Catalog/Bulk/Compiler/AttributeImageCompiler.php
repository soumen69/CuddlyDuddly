<?php

namespace App\Domain\Catalog\Bulk\Compiler;

use App\Domain\Catalog\Bulk\Compiler\Support\AttributeValueResolver;

class AttributeImageCompiler
{
    public function compile(array $rows, AttributeValueResolver $resolver): array
    {
        $compiled = [];

        foreach ($rows as $row) {

            $attrValue = $row['attribute_value'];

            $valueId = $resolver->resolveAny($attrValue);

            if (!$valueId) {
                throw new \Exception("Invalid attribute image value {$attrValue}");
            }

            $compiled[$row['product_code']][] = [
                'attribute_value_id' => $valueId,
                'image_path' => $row['image_url'],
                'is_primary' => (bool)$row['is_primary'],
                'sort_order' => (int)$row['sort_order'],
            ];
        }

        return $compiled;
    }
}
