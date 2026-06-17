<?php

namespace App\Domain\Catalog\Navigation\Contracts;

use App\Models\Products;

interface NavigationPlacementEngineInterface
{
    /**
     * Generate all navigation placements for a product.
     *
     * Flow:
     * Product
     * → Metadata Extraction
     * → Master Category Resolution
     * → Navigation Candidate Discovery
     * → Confidence Scoring
     * → Placement Generation
     *
     * Returns generated master_category_section IDs.
     *
     * @param Products $product
     * @return array<int>
     */
    public function generate(Products $product): array;
}
