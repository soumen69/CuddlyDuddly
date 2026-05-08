<?php

namespace App\Domain\Catalog\Bulk\Template;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class TemplateSheetSchemaCompiler
{
    public function compile(
        TemplateConfigDTO $dto
    ): array {

        $sheets = [];

        foreach ($dto->categories as $categoryId) {

            $categoryName =
                $dto->categoryNameMap[$categoryId];

            $sheetKey =
                'category_' . $categoryId;

            $config = $this->buildCategorySheet(
                $dto,
                $categoryId
            );

            $config['title'] =
                $categoryName;

            $config['sheet_key'] =
                $sheetKey;

            $sheets[$sheetKey] = $config;
        }

        $sheets['master'] = [
            'exists' => true,
            'title' => 'MASTER',
        ];

        return $sheets;
    }

    protected function buildCategorySheet(
        TemplateConfigDTO $dto,
        int $categoryId
    ): array {

        $columns = [
            'group_code',
            'product_name',
            'description',
            'subcategory',
        ];

        if ($dto->brandMode === 'multiple') {
            $columns[] = 'brand';
        }

        foreach (
            $dto->categorySimpleAttributeMap[$categoryId] ?? []
            as $attributeId
        ) {

            $columns[] = $dto
                ->unionAttributes[$attributeId]['name'];
        }

        foreach (
            $dto->categoryVariantAttributeMap[$categoryId] ?? []
            as $attributeId
        ) {

            $columns[] = $dto
                ->unionAttributes[$attributeId]['name'];
        }

        $columns = array_merge($columns, [

            'price',
            'stock',
            'status'

        ]);

        return [

            'exists' => true,

            'category_id' => $categoryId,

            'columns' => $columns
        ];
    }
}
