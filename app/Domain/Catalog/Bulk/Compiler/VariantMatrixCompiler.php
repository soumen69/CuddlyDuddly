<?php

namespace App\Domain\Catalog\Bulk\Compiler;

use Illuminate\Support\Collection;
use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;
use App\Domain\Catalog\Bulk\Compiler\Support\AttributeValueResolver;

class VariantMatrixCompiler
{
    protected AttributeValueResolver $resolver;

    public function __construct(AttributeValueResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function compile(Collection $products, Collection $variants, TemplateConfigDTO $dto): array
    {
        $compiled = [];
        $errors = [];

        $variantGrouped = $variants->groupBy('product_code');

        foreach ($products as $p) {

            try {

                $categoryId = array_search($p['category'], $dto->categoryNameMap);
                $subId = array_search($p['subcategory'], $dto->categorySubcategoryMap[$categoryId] ?? []);

                if (!$categoryId || !$subId) {
                    throw new \Exception("Invalid category/subcategory");
                }

                $variantAttrIds = $dto->categoryVariantAttributeMap[$categoryId] ?? [];
                $simpleAttrIds = $dto->categorySimpleAttributeMap[$categoryId] ?? [];

                $variantRows = $variantGrouped->get($p['product_code'], collect());

                $compiledVariants = [];

                if (empty($variantAttrIds)) {

                    $compiledVariants[] = $this->singleVariant($p);
                } else {

                    if ($variantRows->isEmpty()) {
                        $compiledVariants[] = $this->implicitVariant($p, $variantAttrIds, $dto);
                    } else {

                        foreach ($variantRows as $row) {

                            $valueIds = $this->resolveVariantAttributes($row, $variantAttrIds, $dto);

                            $compiledVariants[] = [
                                'variant_key' => sha1(implode('-', $valueIds)),
                                'variant_attribute_value_ids' => $valueIds,
                                'price' => $row['price_override'] ?? $p['price'],
                                'stock' => $row['stock_override'] ?? $p['stock'],
                                'status' => $row['status'] ?? 1,
                            ];
                        }
                    }
                }

                $compiled[] = [
                    'product' => array_merge($p, [
                        'category_id' => $categoryId,
                        'subcategory_id' => $subId,
                    ]),
                    'variants' => $compiledVariants,
                ];
            } catch (\Throwable $e) {
                $errors[] = [
                    'product_code' => $p['product_code'],
                    'message' => $e->getMessage()
                ];
            }
        }

        return ['products' => $compiled, 'errors' => $errors];
    }

    protected function singleVariant(array $p): array
    {
        return [
            'variant_key' => sha1($p['product_code']),
            'variant_attribute_value_ids' => [],
            'price' => $p['price'],
            'stock' => $p['stock'],
            'status' => 1,
        ];
    }

    protected function implicitVariant(array $p, array $attrIds, TemplateConfigDTO $dto): array
    {
        $ids = $this->resolveVariantAttributes($p, $attrIds, $dto);

        return [
            'variant_key' => sha1(implode('-', $ids)),
            'variant_attribute_value_ids' => $ids,
            'price' => $p['price'],
            'stock' => $p['stock'],
            'status' => 1,
        ];
    }

    protected function resolveVariantAttributes(array $row, array $attrIds, TemplateConfigDTO $dto): array
    {
        $ids = [];

        foreach ($attrIds as $attrId) {
            $name = $dto->unionAttributes[$attrId]['name'];
            $value = $row[$name] ?? null;

            $valId = $this->resolver->resolve($attrId, $value);

            if (!$valId) {
                throw new \Exception("Invalid variant value {$value}");
            }

            $ids[] = $valId;
        }

        return $ids;
    }
}
