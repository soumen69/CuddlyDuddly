<?php

namespace App\Domain\Catalog\Navigation\DTO;

final class NavigationCandidate
{
    public function __construct(
        public readonly int $masterCategorySectionId,

        public readonly int $masterCategoryId,
        public readonly string $masterCategory,

        public readonly int $sectionTypeId,
        public readonly string $sectionType,

        public readonly int $categoryId,
        public readonly string $category,

        public readonly float $confidence = 0.0,

        public readonly array $matchedTokens = [],

        public readonly array $reasons = [],
    ) {}

    public function withConfidence(
        float $confidence,
        array $reasons = []
    ): self {
        return new self(
            masterCategorySectionId: $this->masterCategorySectionId,

            masterCategoryId: $this->masterCategoryId,
            masterCategory: $this->masterCategory,

            sectionTypeId: $this->sectionTypeId,
            sectionType: $this->sectionType,

            categoryId: $this->categoryId,
            category: $this->category,

            confidence: $confidence,

            matchedTokens: $this->matchedTokens,

            reasons: array_values(array_unique([
                ...$this->reasons,
                ...$reasons,
            ]))
        );
    }
}
