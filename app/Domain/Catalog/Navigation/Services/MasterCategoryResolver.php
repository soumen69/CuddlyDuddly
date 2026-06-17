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

class MasterCategoryResolver
{
    /**
     * @return array<MasterCategoryMatch>
     */
    public function resolve(
        ProductNavigationContext $context
    ): array {

        $matches = [];

        $category = strtolower(
            $context->categoryName ?? ''
        );

        $subCategory = strtolower(
            $context->subCategoryName ?? ''
        );

        $gender = collect(
            $context->attributes['gender'] ?? []
        )
            ->map(fn($value) => strtolower($value))
            ->implode(' ');

        /*
        |--------------------------------------------------------------------------
        | BOY FASHION
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($category, 'clothes')
            && str_contains($gender, 'boy')
        ) {

            $matches[] = new MasterCategoryMatch(
                masterCategoryId: 1,
                masterCategoryName: 'BOY FASHION',
                confidence: 95,
                reasons: [
                    'category_match',
                    'gender_match',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GIRL FASHION
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($category, 'clothes')
            && str_contains($gender, 'girl')
        ) {

            $matches[] = new MasterCategoryMatch(
                masterCategoryId: 2,
                masterCategoryName: 'GIRL FASHION',
                confidence: 95,
                reasons: [
                    'category_match',
                    'gender_match',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTWEAR
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($subCategory, 'shoe')
            || str_contains($subCategory, 'sneaker')
            || str_contains($subCategory, 'boot')
            || str_contains($subCategory, 'footwear')
        ) {

            $matches[] = new MasterCategoryMatch(
                masterCategoryId: 3,
                masterCategoryName: 'FOOTWEAR',
                confidence: 95,
                reasons: [
                    'subcategory_match',
                ]
            );
        }

        return $matches;
    }
}
