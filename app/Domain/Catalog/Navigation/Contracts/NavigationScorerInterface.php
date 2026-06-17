<?php

namespace App\Domain\Catalog\Navigation\Contracts;

use App\Domain\Catalog\Navigation\DTO\NavigationCandidate;
use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;

interface NavigationScorerInterface
{
    /**
     * Calculate confidence score.
     */
    public function score(
        ProductNavigationContext $context,
        NavigationCandidate $candidate
    ): float;
}
