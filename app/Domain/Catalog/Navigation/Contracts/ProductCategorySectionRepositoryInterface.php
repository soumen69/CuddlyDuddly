<?php

namespace App\Domain\Catalog\Navigation\Contracts;

interface ProductCategorySectionRepositoryInterface
{
    public function replace(
        int $productId,
        array $masterCategorySectionIds
    ): void;
}
