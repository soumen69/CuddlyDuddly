<?php

namespace App\Domain\Catalog\Navigation\Contracts;

use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;

interface MasterCategoryResolverInterface
{
    /**
     * Resolve all candidate master categories
     * applicable to the product.
     *
     * Returns:
     * [
     *     master_category_id => confidence
     * ]
     */
    public function resolve(
        ProductNavigationContext $context
    ): array;
}
