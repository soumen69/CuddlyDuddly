<?php

namespace App\Domain\Catalog\Bulk\DTO;

class TemplateConfigDTO
{
    public function __construct(

        /*
        |--------------------------------------------------------------------------
        | INGESTION CONTEXT
        |--------------------------------------------------------------------------
        */

        public array $categories,
        public array $subcategories,

        /*
        |--------------------------------------------------------------------------
        | BRAND STRATEGY
        |--------------------------------------------------------------------------
        */

        public string $brandMode,
        public ?int $brandId,
        public ?string $brandName,
        public array $brandMap,

        /*
        |--------------------------------------------------------------------------
        | INGESTION SCALE
        |--------------------------------------------------------------------------
        */

        public int $volume,

        /*
        |--------------------------------------------------------------------------
        | CATEGORY INTELLIGENCE
        |--------------------------------------------------------------------------
        */

        public array $categoryNameMap,
        public array $categorySubcategoryMap,

        /*
        |--------------------------------------------------------------------------
        | ATTRIBUTE INTELLIGENCE
        |--------------------------------------------------------------------------
        */

        public array $unionAttributes,

        public array $variantAttributes,
        public array $simpleAttributes,
        public array $visualAttributes,

        /*
        |--------------------------------------------------------------------------
        | ATTRIBUTE VALUE INTELLIGENCE
        |--------------------------------------------------------------------------
        */

        public array $attributeValueMap,
        public array $requiredMatrix,

        /*
        |--------------------------------------------------------------------------
        | CATEGORY ATTRIBUTE CONTEXT
        |--------------------------------------------------------------------------
        */

        public array $categoryVariantAttributeMap,
        public array $categorySimpleAttributeMap,
        public array $categoryVisualAttributeMap,

    ) {}
}
