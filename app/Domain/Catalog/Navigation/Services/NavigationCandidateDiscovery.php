<?php

namespace App\Domain\Catalog\Navigation\Services;

use App\Domain\Catalog\Navigation\Contracts\NavigationCandidateDiscoveryInterface;
use App\Domain\Catalog\Navigation\Contracts\NavigationIndexRepositoryInterface;
use App\Domain\Catalog\Navigation\DTO\NavigationCandidate;
use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
use App\Domain\Catalog\Navigation\Support\TokenNormalizer;

class NavigationCandidateDiscovery implements NavigationCandidateDiscoveryInterface
{
    public function __construct(
        private readonly NavigationIndexRepositoryInterface $navigationIndexRepository,
        private readonly TokenNormalizer $normalizer
    ) {}

    public function discover(
        ProductNavigationContext $context,
        array $masterCategoryIds
    ): array {
        $candidates = [];

        $productTokens = $context->tokens;

        foreach ($this->navigationIndexRepository->all() as $node) {
            if (
                ! in_array(
                    $node['master_category_id'],
                    $masterCategoryIds,
                    true
                )
            ) {
                continue;
            }

            $searchTokens = $this->buildNodeTokens($node);

            $matchedTokens = $this->matchedTokens(
                $productTokens,
                $searchTokens
            );

            if (count($matchedTokens) < 2) {
                continue;
            }

            $candidates[] = new NavigationCandidate(
                masterCategorySectionId: $node['master_category_section_id'],

                masterCategoryId: $node['master_category_id'],
                masterCategory: $node['master_category_name'],

                sectionTypeId: $node['section_type_id'],
                sectionType: $node['section_type_name'],

                categoryId: $node['category_id'],
                category: $node['category_name'],

                matchedTokens: $matchedTokens,

                reasons: [
                    'token_match',
                ]
            );
        }

        return $candidates;
    }

    private function buildNodeTokens(array $node): array
    {
        $tokens = [];

        $sources = [
            $node['category_name'] ?? null,
        ];

        foreach ($sources as $source) {

            if (blank($source)) {
                continue;
            }

            $tokens = array_merge(
                $tokens,
                $this->normalizer->tokens($source)
            );
        }

        return array_values(
            array_unique($tokens)
        );
    }

    private function matchedTokens(
        array $productTokens,
        array $candidateTokens
    ): array {
        return array_values(
            array_unique(
                array_intersect(
                    $productTokens,
                    $candidateTokens
                )
            )
        );
    }
}
