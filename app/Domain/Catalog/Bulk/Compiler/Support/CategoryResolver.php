<?php

namespace App\Domain\Catalog\Bulk\Compiler\Support;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class CategoryResolver
{
    public function resolve(array $row, TemplateConfigDTO $dto): array
    {
        $categoryName = trim($row['category'] ?? '');

        $categoryId = array_search($categoryName, $dto->categoryNameMap);

        if (!$categoryId) {
            throw new \Exception("Invalid category: {$categoryName}");
        }

        $subName = trim($row['subcategory'] ?? '');

        $subMap = $dto->categorySubcategoryMap[$categoryId] ?? [];

        $subId = array_search($subName, $subMap);

        if (!$subId) {
            throw new \Exception("Invalid subcategory '{$subName}' for category {$categoryName}");
        }

        return [$categoryId, $subId];
    }
}
