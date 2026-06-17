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

class PlacementBuilder implements PlacementBuilderInterface
{
    private const MIN_CONFIDENCE = 30;

    public function __construct(
        private readonly MasterCategoryResolver $masterCategoryResolver,
        private readonly NavigationCandidateDiscovery $candidateDiscovery,
        private readonly NavigationScorer $scorer
    ) {}

    public function build(
        ProductNavigationContext $context
    ): array {

        $placements = [];

        $masterCategoryMatches =
            $this->masterCategoryResolver
                ->resolve($context);

        if (empty($masterCategoryMatches)) {
            return [];
        }

        $masterCategoryIds = array_map(
            fn($match) => $match->masterCategoryId,
            $masterCategoryMatches
        );

        foreach (
            $this->candidateDiscovery->discover(
                $context,
                $masterCategoryIds
            )
            as $candidate
        ) {

            $confidence = $this->scorer->score(
                $context,
                $candidate
            );

            if ($confidence < self::MIN_CONFIDENCE) {
                continue;
            }

            $placements[] = new NavigationPlacement(
                masterCategorySectionId: $candidate->masterCategorySectionId,

                masterCategoryId: $candidate->masterCategoryId,

                masterCategory: $candidate->masterCategory,

                sectionType: $candidate->sectionType,

                category: $candidate->category,

                confidence: $confidence,

                reasons: $candidate->reasons
            );
        }

        usort(
            $placements,
            fn($a, $b) => $b->confidence <=> $a->confidence
        );

        return $placements;
    }
}
