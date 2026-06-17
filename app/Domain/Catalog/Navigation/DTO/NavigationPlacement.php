<?php

namespace App\Domain\Catalog\Navigation\DTO;

final class NavigationPlacement
{
    public function __construct(
        public readonly int $masterCategorySectionId,

        public readonly int $masterCategoryId,

        public readonly string $masterCategory,

        public readonly string $sectionType,

        public readonly string $category,

        public readonly float $confidence,

        public readonly array $reasons = []
    ) {}
}
