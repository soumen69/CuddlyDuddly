<?php

namespace App\Domain\Catalog\Navigation\DTO;

final class ProductNavigationContext
{
    public function __construct(
        public readonly int $productId,

        public readonly string $productName,

        public readonly ?int $categoryId,
        public readonly ?string $categoryName,

        public readonly ?int $subCategoryId,
        public readonly ?string $subCategoryName,

        public readonly ?int $brandId,
        public readonly ?string $brandName,

        public readonly float $price,

        /**
         * Raw attribute values.
         *
         * Example:
         * [
         *     'gender' => ['boy'],
         *     'age' => ['4-6 years'],
         *     'color' => ['red', 'blue']
         * ]
         */
        public readonly array $attributes,

        /**
         * Fully normalized search tokens.
         *
         * Generated from:
         * - product name
         * - category
         * - subcategory
         * - brand
         * - attributes
         * - attribute values
         *
         * Example:
         * [
         *     'boys',
         *     'boy',
         *     'ethnic',
         *     'wear',
         *     'kurta',
         *     'gucci'
         * ]
         */
        public readonly array $tokens
    ) {}
}
