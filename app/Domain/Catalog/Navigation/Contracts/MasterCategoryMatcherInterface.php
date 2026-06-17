<?php

namespace App\Domain\Catalog\Navigation\Contracts;

use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
use App\Domain\Catalog\Navigation\DTO\MasterCategoryMatch;

interface MasterCategoryMatcherInterface
{
    /**
     * Return possible master-category matches
     * discovered by this matcher.
     *
     * @return array<MasterCategoryMatch>
     */
    public function match(
        ProductNavigationContext $context
    ): array;
}
