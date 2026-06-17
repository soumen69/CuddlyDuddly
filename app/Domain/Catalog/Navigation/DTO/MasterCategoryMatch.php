<?php

namespace App\Domain\Catalog\Navigation\DTO;

final class MasterCategoryMatch
{
    public function __construct(
        public readonly int $masterCategoryId,
        public readonly string $masterCategoryName,
        public readonly float $confidence,
        public readonly array $reasons = []
    ) {}
}
