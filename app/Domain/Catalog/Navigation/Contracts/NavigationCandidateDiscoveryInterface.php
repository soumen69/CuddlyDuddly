<?php

namespace App\Domain\Catalog\Navigation\Contracts;

use App\Domain\Catalog\Navigation\DTO\NavigationCandidate;
use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;

interface NavigationCandidateDiscoveryInterface
{
    /**
     * Discover all possible navigation candidates
     * from the navigation hierarchy.
     *
     * This stage should be permissive and focus on
     * identifying potential matches rather than
     * calculating confidence.
     *
     * @return NavigationCandidate[]
     */
    public function discover(
        ProductNavigationContext $context,
        array $masterCategoryIds
    ): array;
}
