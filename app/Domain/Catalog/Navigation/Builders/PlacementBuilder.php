<?php

// namespace App\Domain\Catalog\Navigation\Builders;

// use App\Domain\Catalog\Navigation\Contracts\PlacementBuilderInterface;
// use App\Domain\Catalog\Navigation\DTO\NavigationPlacement;
// use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
// use App\Domain\Catalog\Navigation\Services\NavigationCandidateDiscovery;
// use App\Domain\Catalog\Navigation\Services\NavigationScorer;

// class PlacementBuilder implements PlacementBuilderInterface
// {
//     private const MIN_CONFIDENCE = 30;

//     public function __construct(
//         private readonly NavigationCandidateDiscovery $candidateDiscovery,
//         private readonly NavigationScorer $scorer
//     ) {}

//     public function build(
//         ProductNavigationContext $context
//     ): array {
//         $placements = [];

//         foreach (
//             $this->candidateDiscovery->discover($context)
//             as $candidate
//         ) {

//             $confidence = $this->scorer->score(
//                 $context,
//                 $candidate
//             );

//             if ($confidence < self::MIN_CONFIDENCE) {
//                 continue;
//             }

//             $placements[] = new NavigationPlacement(
//                 masterCategorySectionId: $candidate->masterCategorySectionId,

//                 masterCategoryId: $candidate->masterCategoryId,

//                 masterCategory: $candidate->masterCategory,

//                 sectionType: $candidate->sectionType,

//                 category: $candidate->category,

//                 confidence: $confidence,

//                 reasons: $candidate->reasons
//             );
//         }

//         usort(
//             $placements,
//             fn($a, $b) => $b->confidence <=> $a->confidence
//         );

//         return $placements;
//     }
// }


namespace App\Domain\Catalog\Navigation\Builders;

use App\Domain\Catalog\Navigation\Contracts\PlacementBuilderInterface;
use App\Domain\Catalog\Navigation\DTO\NavigationPlacement;
use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
use App\Domain\Catalog\Navigation\Services\MasterCategoryResolver;
use App\Domain\Catalog\Navigation\Services\NavigationCandidateDiscovery;
use App\Domain\Catalog\Navigation\Services\NavigationScorer;
use App\Domain\Catalog\Navigation\Services\CategoryPlacementResolver;
use App\Domain\Catalog\Navigation\Repositories\NavigationIndexRepository;
use App\Domain\Catalog\Navigation\Services\BrandPlacementResolver;

class PlacementBuilder implements PlacementBuilderInterface
{
    private const MIN_CONFIDENCE = 30;

    public function __construct(
        private readonly MasterCategoryResolver $masterCategoryResolver,
        private readonly CategoryPlacementResolver $categoryPlacementResolver,
        private readonly BrandPlacementResolver $brandPlacementResolver,
        private readonly NavigationIndexRepository $navigationIndexRepository,
        private readonly NavigationCandidateDiscovery $candidateDiscovery,
        private readonly NavigationScorer $scorer
    ) {}

    public function build(ProductNavigationContext $context): array
    {
        $placements = [];
        $masterCategoryMatches = $this->masterCategoryResolver->resolve($context);

        if (empty($masterCategoryMatches)) {
            return [];
        }

        $placements = $this->buildCategoryPlacements(
            $context,
            $masterCategoryMatches
        );

        $placements = array_merge($placements, $this->buildBrandPlacements($context));

        $placements = collect($placements)
            ->unique(
                fn($placement) => $placement->masterCategorySectionId
            )
            ->values()
            ->all();

        usort(
            $placements,
            fn($a, $b) => $b->confidence <=> $a->confidence
        );
        return $placements;
    }

    private function buildCategoryPlacements(ProductNavigationContext $context, array $masterCategoryMatches): array
    {
        $placements = [];
        $index = collect($this->navigationIndexRepository->all())->keyBy('master_category_section_id');

        foreach ($masterCategoryMatches as $match) {
            $sectionIds =
                $this->categoryPlacementResolver
                ->resolve(
                    $match->masterCategoryId,
                    $context->subCategoryId
                );

            foreach ($sectionIds as $sectionId) {
                $node = $index->get($sectionId);

                if (! $node) {
                    continue;
                }

                $placements[] = new NavigationPlacement(
                    masterCategorySectionId: $sectionId,
                    masterCategoryId: $node['master_category_id'],
                    masterCategory: $node['master_category_name'],
                    sectionType: $node['section_type_name'],
                    category: $node['category_name'],
                    confidence: 100,
                    reasons: [
                        'subcategory_mapping',
                    ]
                );
            }
        }
        return $placements;
    }

    private function buildBrandPlacements(ProductNavigationContext $context): array
    {
        $placements = [];
        if (! $context->brandId) {
            return [];
        }

        $sectionIds = $this->brandPlacementResolver->resolve($context->brandId);
        $index = collect($this->navigationIndexRepository->all())->keyBy('master_category_section_id');
        foreach ($sectionIds as $sectionId) {
            $node = $index->get($sectionId);
            if (! $node) {
                continue;
            }

            $placements[] = new NavigationPlacement(
                masterCategorySectionId: $sectionId,
                masterCategoryId: $node['master_category_id'],
                masterCategory: $node['master_category_name'],
                sectionType: $node['section_type_name'],
                category: $node['category_name'],
                confidence: 100,
                reasons: ['brand_mapping']
            );
        }

        return $placements;
    }
}
