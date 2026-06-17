<?php

namespace App\Domain\Catalog\Navigation\Contracts;

use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
use App\Models\Products;

interface MetadataExtractorInterface
{
    /**
     * Extract all navigation-relevant metadata
     * from a committed product.
     */
    public function extract(Products $product): ProductNavigationContext;
}
