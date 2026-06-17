<?php

namespace App\Domain\Catalog\Navigation\Services;

use App\Domain\Catalog\Navigation\Contracts\MetadataExtractorInterface;
use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
use App\Domain\Catalog\Navigation\Support\TokenNormalizer;
use App\Models\Products;

class MetadataExtractor implements MetadataExtractorInterface
{
    public function __construct(
        private readonly TokenNormalizer $normalizer
    ) {}

    public function extract(Products $product): ProductNavigationContext
    {
        $product->loadMissing([
            'productCategory',
            'subCategory',
            'brand',
            'attributeValues.attributeValue.attribute',
            'variants.attributeValues.attributeValue.attribute',
        ]);

        $attributes = [];

        foreach ($product->attributeValues as $attributeValueRelation) {

            $attributeValue = $attributeValueRelation->attributeValue;

            if (! $attributeValue) {
                continue;
            }

            $attribute = $attributeValue->attribute;

            if (! $attribute) {
                continue;
            }

            $key = $attribute->slug;

            $attributes[$key] ??= [];
            $attributes[$key][] = $attributeValue->value;
        }

        foreach ($product->variants as $variant) {
            foreach ($variant->attributeValues as $variantAttributeValue) {

                $attributeValue = $variantAttributeValue->attributeValue;

                if (! $attributeValue) {
                    continue;
                }

                $attribute = $attributeValue->attribute;

                if (! $attribute) {
                    continue;
                }

                $key = $attribute->slug;

                $attributes[$key] ??= [];
                $attributes[$key][] = $attributeValue->value;
            }
        }

        foreach ($attributes as $key => $values) {
            $attributes[$key] = array_values(array_unique($values));
        }

        $tokenSources = [
            $product->name,
            $product->productCategory?->name,
            $product->subCategory?->name,
            $product->brand?->name,
        ];

        foreach ($attributes as $values) {
            foreach ($values as $value) {
                $tokenSources[] = $value;
            }
        }

        $tokens = [];

        foreach ($tokenSources as $source) {
            if (blank($source)) {
                continue;
            }

            $tokens = array_merge(
                $tokens,
                $this->normalizer->tokens($source)
            );
        }

        $tokens = array_values(array_unique($tokens));

        return new ProductNavigationContext(
            productId: (int) $product->id,

            productName: (string) $product->name,

            categoryId: $product->product_categories_id,
            categoryName: $product->productCategory?->name,

            subCategoryId: $product->product_sub_categories_id,
            subCategoryName: $product->subCategory?->name,

            brandId: $product->brand_id,
            brandName: $product->brand?->name,

            price: (float) $product->price,

            attributes: $attributes,

            tokens: $tokens
        );
    }
}
