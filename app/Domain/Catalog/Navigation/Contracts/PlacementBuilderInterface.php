<?php

namespace App\Domain\Catalog\Navigation\Contracts;

use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
use App\Domain\Catalog\Navigation\DTO\NavigationPlacement;

interface PlacementBuilderInterface
{
    /**
     * Build final placements.
     *
     * @return array<NavigationPlacement>
     */
    public function build(
        ProductNavigationContext $context
    ): array;
}
