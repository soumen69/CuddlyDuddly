<?php

namespace App\Domain\Catalog\Bulk\Builder;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;
use App\Domain\Catalog\Bulk\Intelligence\AttributeUnionService;
use App\Domain\Catalog\Bulk\Intelligence\AttributeClassifier;
use App\Domain\Catalog\Bulk\Intelligence\CategoryAttributeContextBuilder;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use App\Models\Brands;

class TemplateConfigBuilder
{
    public function __construct(
        protected AttributeUnionService $unionService,
        protected AttributeClassifier $classifier,
        protected CategoryAttributeContextBuilder $contextBuilder
    ) {}

    public function buildFromWizard(array $payload): TemplateConfigDTO
    {
        $categories = $payload['categories'];

        $subcategories = $payload['subcategories'] ?? [];

        $union = $this->unionService->build($categories);

        $classified = $this->classifier->classify($union);

        $categoryContext = $this->contextBuilder
            ->build($union, $categories);

        $attributeValueMap = $this->buildAttributeValueMap($union);

        $requiredMatrix = $this->buildRequiredMatrix($union);

        // $categorySubMap = $this->buildSubcategoryMap($categories);

        $categorySubMap = $this->buildSubcategoryMap(
            $categories,
            $subcategories
        );

        $categoryNameMap = ProductCategory::query()
            ->whereIn('id', $categories)
            ->pluck('name', 'id')
            ->toArray();

        $brandMap = Brands::query()
            ->where('is_active', 1)
            ->pluck('name', 'id')
            ->toArray();

        $brandName = null;

        if (!empty($payload['brand_id'])) {

            $brandName = Brands::where(
                'id',
                $payload['brand_id']
            )->value('name');
        }

        return new TemplateConfigDTO(

            categories: $categories,
            subcategories: $subcategories,
            brandName: $brandName,
            brandMap: $brandMap,
            brandMode: $payload['brand_mode'],

            brandId: $payload['brand_id'] ?? null,

            volume: (int) $payload['volume'],

            categoryNameMap: $categoryNameMap,

            categorySubcategoryMap: $categorySubMap,

            unionAttributes: $union,

            variantAttributes: $classified['variant'],

            simpleAttributes: $classified['simple'],

            visualAttributes: $classified['visual'],

            attributeValueMap: $attributeValueMap,

            requiredMatrix: $requiredMatrix,

            categoryVariantAttributeMap: $categoryContext['variant'],

            categorySimpleAttributeMap: $categoryContext['simple'],

            categoryVisualAttributeMap: $categoryContext['visual'],
        );
    }

    protected function buildSubcategoryMap(
        array $categoryIds,
        array $selectedSubcategories
    ): array {
        $subs = ProductSubCategory::whereIn(
            'product_categories_id',
            $categoryIds
        )
            ->whereIn(
                'id',
                $selectedSubcategories
            )
            ->where('status', 1)
            ->get();

        $map = [];

        foreach ($subs as $s) {
            $map[$s->product_categories_id][$s->id] = $s->name;
        }

        return $map;
    }

    protected function buildAttributeValueMap(array $union): array
    {
        $map = [];

        foreach ($union as $attr) {
            $map[$attr['id']] = $attr['values'];
        }

        return $map;
    }

    protected function buildRequiredMatrix(array $union): array
    {
        $matrix = [];

        foreach ($union as $attr) {
            foreach ($attr['required_in_categories'] as $catId) {
                $matrix[$catId][] = $attr['id'];
            }
        }

        return $matrix;
    }
}
