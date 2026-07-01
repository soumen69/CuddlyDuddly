<?php

// namespace App\Domain\Catalog\Navigation\Services;

// use App\Domain\Catalog\Navigation\DTO\MasterCategoryMatch;
// use App\Domain\Catalog\Navigation\DTO\NavigationCandidate;
// use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;

// class MasterCategoryResolver
// {
//     public function __construct(
//         private readonly NavigationCandidateDiscovery $candidateDiscovery,
//         private readonly NavigationScorer $scorer
//     ) {}

//     /**
//      * @return array<MasterCategoryMatch>
//      */
//     public function resolve(
//         ProductNavigationContext $context
//     ): array {
//         $candidates = $this->candidateDiscovery->discover($context);

//         if (empty($candidates)) {
//             return [];
//         }

//         $scores = [];

//         foreach ($candidates as $candidate) {

//             $confidence = $this->scorer->score(
//                 $context,
//                 $candidate
//             );

//             $masterCategoryId = $candidate->masterCategoryId;

//             if (! isset($scores[$masterCategoryId])) {

//                 $scores[$masterCategoryId] = [
//                     'id' => $masterCategoryId,
//                     'name' => $candidate->masterCategory,
//                     'confidence' => 0,
//                     'reasons' => [],
//                 ];
//             }

//             $scores[$masterCategoryId]['confidence']
//                 += $confidence;

//             $scores[$masterCategoryId]['reasons'] = array_unique([
//                 ...$scores[$masterCategoryId]['reasons'],
//                 ...$candidate->reasons,
//             ]);
//         }

//         $matches = [];

//         foreach ($scores as $score) {

//             $matches[] = new MasterCategoryMatch(
//                 masterCategoryId: $score['id'],
//                 masterCategoryName: $score['name'],
//                 confidence: min(100, $score['confidence']),
//                 reasons: $score['reasons']
//             );
//         }

//         usort(
//             $matches,
//             fn(
//                 MasterCategoryMatch $a,
//                 MasterCategoryMatch $b
//             ) => $b->confidence <=> $a->confidence
//         );

//         return $matches;
//     }
// }



namespace App\Domain\Catalog\Navigation\Services;

use App\Domain\Catalog\Navigation\DTO\MasterCategoryMatch;
use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
use App\Domain\Catalog\Navigation\Repositories\MasterCategoryMappingRepository;

class MasterCategoryResolver
{
    public function __construct(
        private readonly MasterCategoryMappingRepository $repository
    ) {}

    /**
     * @return array<MasterCategoryMatch>
     */
    public function resolve(
        ProductNavigationContext $context
    ): array {

        $matches = [];

        $mappings = $this->repository->findMatches(
            $context->categoryId,
            $context->subCategoryId
        );

        foreach ($mappings as $mapping) {

            $masterCategory =
                $mapping->masterCategory;

            if (! $masterCategory) {
                continue;
            }

            $matches[$masterCategory->id] =
                new MasterCategoryMatch(
                    masterCategoryId: $masterCategory->id,
                    masterCategoryName: $masterCategory->name,
                    confidence: 80,
                    reasons: [
                        'mapping_match',
                    ]
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Clothes & Shoes Specialization
        |--------------------------------------------------------------------------
        */

        if (
            str_contains(
                strtolower(
                    $context->categoryName ?? ''
                ),
                'clothes'
            )
        ) {

            $gender = $this->extractGender(
                $context
            );

            $matches = [];

            if ($gender === 'boys') {

                $matches[1] =
                    new MasterCategoryMatch(
                        masterCategoryId: 1,
                        masterCategoryName: 'BOY FASHION',
                        confidence: 95,
                        reasons: [
                            'gender_refinement',
                        ]
                    );
            }

            if ($gender === 'girls') {

                $matches[2] =
                    new MasterCategoryMatch(
                        masterCategoryId: 2,
                        masterCategoryName: 'GIRL FASHION',
                        confidence: 95,
                        reasons: [
                            'gender_refinement',
                        ]
                    );
            }
        }

        return array_values($matches);
    }

    private function extractGender(
        ProductNavigationContext $context
    ): ?string {

        foreach (
            $context->attributes
            as $key => $values
        ) {

            if (
                str_starts_with(
                    strtolower($key),
                    'gender'
                )
            ) {

                return strtolower(
                    $values[0] ?? ''
                );
            }
        }

        return null;
    }
}
