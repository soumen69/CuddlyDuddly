<?php

namespace App\Domain\Catalog\Navigation\Services;

use App\Domain\Catalog\Navigation\Contracts\MetadataExtractorInterface;
use App\Domain\Catalog\Navigation\Contracts\NavigationPlacementEngineInterface;
use App\Domain\Catalog\Navigation\Contracts\PlacementBuilderInterface;
use App\Domain\Catalog\Navigation\Contracts\ProductCategorySectionRepositoryInterface;
use App\Models\Products;

class NavigationPlacementEngine implements NavigationPlacementEngineInterface
{
    public function __construct(
        private readonly MetadataExtractorInterface $metadataExtractor,

        private readonly PlacementBuilderInterface $placementBuilder,

        private readonly ProductCategorySectionRepositoryInterface $repository
    ) {}

    public function generate(
        Products $product
    ): array {
        $context = $this->metadataExtractor
            ->extract($product);

        $placements = $this->placementBuilder
            ->build($context);

        $masterCategorySectionIds = array_map(
            fn($placement) => $placement->masterCategorySectionId,
            $placements
        );

        $this->repository->replace(
            $product->id,
            $masterCategorySectionIds
        );

        return $masterCategorySectionIds;
    }
}
