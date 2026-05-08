<?php

namespace App\Domain\Catalog\Bulk\Compiler;

use Exception;
use Illuminate\Support\Collection;
use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;
use App\Domain\Catalog\Bulk\Compiler\Support\AttributeValueResolver;

class ProductFamilyCompiler
{
    public function compile(
        Collection $rows,
        TemplateConfigDTO $dto,
        AttributeValueResolver $resolver
    ): array {

        $compiled = [];
        $errors = [];

        $families = $rows->groupBy(
            fn($row) => $this->groupCode($row)
        );

        foreach ($families as $groupCode => $familyRows) {

            try {

                $family = $this->compileFamily(
                    $groupCode,
                    $familyRows,
                    $dto,
                    $resolver
                );

                $family['compile_status'] = 'success';

                $compiled[] = $family;
            } catch (\Throwable $e) {

                $first = $familyRows->first();

                $compiled[] = [
                    'compile_status' => 'failed',
                    'compile_errors' => [
                        [
                            'group_code' => $groupCode,
                            'message' => $e->getMessage(),
                        ]
                    ],

                    'product' => [
                        'group_code' => $groupCode,
                        'category_id' => null,
                        'subcategory_id' => null,
                        'name' => $first['product_name'] ?? '',
                        'description' => $first['description'] ?? '',
                        'brand_id' => null,
                    ],
                    'simple_attributes' => [],
                    'variants' => [],
                ];
                $errors[] = [
                    'group_code' => $groupCode,
                    'message' => $e->getMessage(),
                ];
            }
        }

        return [
            'products' => $compiled,
            'errors' => $errors,
        ];
    }

    protected function compileFamily(
        string $groupCode,
        Collection $rows,
        TemplateConfigDTO $dto,
        AttributeValueResolver $resolver
    ): array {

        $first = $rows->first();

        $categoryId = $this->resolveCategoryId(
            $first['_sheet'] ?? '',
            $dto
        );

        $subcategoryId = $this->resolveSubcategoryId(
            $categoryId,
            $first['subcategory'] ?? null,
            $dto
        );

        if (!$categoryId) {
            throw new Exception(
                'Unable to resolve category from sheet.'
            );
        }

        if (!$subcategoryId) {

            throw new Exception(
                'Unable to resolve subcategory.'
            );
        }

        $variantAttrIds = $dto
            ->categoryVariantAttributeMap[$categoryId] ?? [];

        $simpleAttrIds = $dto
            ->categorySimpleAttributeMap[$categoryId] ?? [];

        $simpleAttributeValueIds =
            $this->resolveSimpleAttributes(
                $first,
                $simpleAttrIds,
                $dto,
                $resolver
            );

        $isVariantProduct =
            $this->isVariantProduct(
                $rows,
                $variantAttrIds,
                $dto
            );

        $variants = [];

        $isVariantFamily = $isVariantProduct;

        foreach ($rows as $row) {

            $variantValueIds =
                $this->resolveVariantAttributes(
                    $row,
                    $variantAttrIds,
                    $dto,
                    $resolver,
                    $isVariantFamily
                );
            $variants[] = [

                'variant_key' => sha1(
                    implode('-', $variantValueIds)
                ),

                'variant_attribute_value_ids' =>
                $variantValueIds,

                'price' => (float) (
                    $row['price'] ?? 0
                ),

                'stock' => (int) (
                    $row['stock'] ?? 0
                ),

                'status' => $this->normalizeStatus(
                    $row['status'] ?? 'active'
                ),
            ];
        }

        return [

            'product' => [
                'is_variant_product' => $isVariantProduct,
                'group_code' => $groupCode,
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'name' => $first['product_name'] ?? '',
                'description' => $first['description'] ?? '',
                'brand_id' => $dto->brandMode === 'single'
                    ? $dto->brandId
                    : $this->resolveBrandId(
                        $first['brand'] ?? null,
                        $dto
                    ),

                'price' => collect($variants)
                    ->min('price'),

                'stock' => collect($variants)
                    ->sum('stock'),
            ],

            'simple_attributes' =>
            $simpleAttributeValueIds,

            'variants' => $variants,
        ];
    }

    protected function resolveSubcategoryId(
        int $categoryId,
        ?string $subcategory,
        TemplateConfigDTO $dto
    ): ?int {

        if (!$subcategory) {
            return null;
        }

        $subcategories =
            $dto->categorySubcategoryMap[$categoryId]
            ?? [];

        foreach ($subcategories as $id => $name) {

            if (
                $this->normalize($name)
                ===
                $this->normalize($subcategory)
            ) {

                return (int) $id;
            }
        }

        return null;
    }

    protected function resolveBrandId(
        ?string $brand,
        TemplateConfigDTO $dto
    ): ?int {

        if (!$brand) {
            return null;
        }

        foreach ($dto->brandMap as $id => $name) {

            if (
                mb_strtolower(trim($name))
                ===
                mb_strtolower(trim($brand))
            ) {
                return (int) $id;
            }
        }

        throw new Exception(
            "Invalid brand '{$brand}'"
        );
    }

    protected function resolveSimpleAttributes(
        array $row,
        array $attributeIds,
        TemplateConfigDTO $dto,
        AttributeValueResolver $resolver
    ): array {

        $resolved = [];

        foreach ($attributeIds as $attributeId) {

            $attribute =
                $dto->unionAttributes[$attributeId];

            $name = $this->normalizeColumn(
                $attribute['name']
            );

            $value = $row[$name] ?? null;

            if (!$value) {
                continue;
            }

            $valueId = $resolver->resolve(
                $attributeId,
                $value
            );

            if (!$valueId) {

                throw new Exception(
                    "Invalid attribute value '{$value}' for {$attribute['name']}"
                );
            }

            $resolved[] = $valueId;
        }

        return $resolved;
    }

    protected function resolveVariantAttributes(
        array $row,
        array $attributeIds,
        TemplateConfigDTO $dto,
        AttributeValueResolver $resolver,
        bool $isVariantFamily
    ): array {

        $resolved = [];

        foreach ($attributeIds as $attributeId) {

            $attribute =
                $dto->unionAttributes[$attributeId];

            $name = $this->normalizeColumn(
                $attribute['name']
            );

            $value = $row[$name] ?? null;

            if (!$value) {
                if ($isVariantFamily) {
                    throw new Exception(
                        "Missing variant attribute '{$attribute['name']}'"
                    );
                }
                continue;
            }

            $valueId = $resolver->resolve(
                $attributeId,
                $value
            );

            if (!$valueId) {

                throw new Exception(
                    "Invalid variant value '{$value}'"
                );
            }

            $resolved[] = $valueId;
        }

        return $resolved;
    }
    protected function normalizeColumn(
        string $value
    ): string {

        $value = mb_strtolower(
            trim($value)
        );

        $value = preg_replace(
            '/[^a-z0-9]+/',
            '_',
            $value
        );

        return trim(
            $value,
            '_'
        );
    }

    protected function resolveCategoryId(
        string $sheetName,
        TemplateConfigDTO $dto
    ): ?int {
        foreach (
            $dto->categoryNameMap
            as $id => $name
        ) {

            if (
                $this->normalizeColumn($name)
                === $sheetName
            ) {
                return (int) $id;
            }
        }

        return null;
    }

    protected function normalize(
        string $value
    ): string {

        return mb_strtolower(
            trim(
                preg_replace(
                    '/\s+/',
                    ' ',
                    $value
                )
            )
        );
    }

    protected function groupCode(
        array $row
    ): string {

        return trim(
            $row['group_code']
                ?? uniqid('GRP-')
        );
    }

    protected function normalizeStatus(
        string $status
    ): int {

        return mb_strtolower(
            trim($status)
        ) === 'inactive'
            ? 0
            : 1;
    }


    protected function isVariantProduct(
        Collection $rows,
        array $variantAttrIds,
        TemplateConfigDTO $dto
    ): bool {

        foreach ($rows as $row) {

            foreach ($variantAttrIds as $attributeId) {

                $attribute =
                    $dto->unionAttributes[$attributeId];

                $column = $this->normalizeColumn(
                    $attribute['name']
                );

                $value = $row[$column] ?? null;

                if (
                    filled($value)
                ) {

                    return true;
                }
            }
        }

        return false;
    }
}
