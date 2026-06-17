<?php

namespace App\Domain\Catalog\Navigation\Services;

use App\Domain\Catalog\Navigation\Contracts\NavigationScorerInterface;
use App\Domain\Catalog\Navigation\DTO\NavigationCandidate;
use App\Domain\Catalog\Navigation\DTO\ProductNavigationContext;
use App\Domain\Catalog\Navigation\Support\TokenNormalizer;

class NavigationScorer implements NavigationScorerInterface
{
    public function __construct(
        private readonly TokenNormalizer $normalizer
    ) {}

    public function score(
        ProductNavigationContext $context,
        NavigationCandidate $candidate
    ): float {
        $score = 0;

        /*
         |--------------------------------------------------------------------------
         | Product Name Match
         |--------------------------------------------------------------------------
         */

        $score += $this->productNameScore(
            $context,
            $candidate
        );

        /*
         |--------------------------------------------------------------------------
         | Sub Category Match
         |--------------------------------------------------------------------------
         */

        $score += $this->subCategoryScore(
            $context,
            $candidate
        );

        /*
         |--------------------------------------------------------------------------
         | Category Match
         |--------------------------------------------------------------------------
         */

        $score += $this->categoryScore(
            $context,
            $candidate
        );

        /*
         |--------------------------------------------------------------------------
         | Attribute Match
         |--------------------------------------------------------------------------
         */

        $score += $this->attributeScore(
            $context,
            $candidate
        );

        /*
         |--------------------------------------------------------------------------
         | Brand Match
         |--------------------------------------------------------------------------
         */

        $score += $this->brandScore(
            $context,
            $candidate
        );

        return min(100, $score);
    }

    private function productNameScore(
        ProductNavigationContext $context,
        NavigationCandidate $candidate
    ): float {
        $nameTokens = $this->normalizer->tokens(
            $context->productName
        );

        $matches = array_intersect(
            $nameTokens,
            $candidate->matchedTokens
        );

        return count($matches) * 15;
    }

    private function subCategoryScore(
        ProductNavigationContext $context,
        NavigationCandidate $candidate
    ): float {
        if (blank($context->subCategoryName)) {
            return 0;
        }

        $tokens = $this->normalizer->tokens(
            $context->subCategoryName
        );

        $matches = array_intersect(
            $tokens,
            $candidate->matchedTokens
        );

        return count($matches) * 20;
    }

    private function categoryScore(
        ProductNavigationContext $context,
        NavigationCandidate $candidate
    ): float {
        if (blank($context->categoryName)) {
            return 0;
        }

        $tokens = $this->normalizer->tokens(
            $context->categoryName
        );

        $matches = array_intersect(
            $tokens,
            $candidate->matchedTokens
        );

        return count($matches) * 10;
    }

    private function attributeScore(
        ProductNavigationContext $context,
        NavigationCandidate $candidate
    ): float {
        $score = 0;

        foreach ($context->attributes as $values) {

            $tokens = [];

            foreach ($values as $value) {
                $tokens = array_merge(
                    $tokens,
                    $this->normalizer->tokens($value)
                );
            }

            $matches = array_intersect(
                $tokens,
                $candidate->matchedTokens
            );

            $score += count($matches) * 15;
        }

        return $score;
    }

    private function brandScore(
        ProductNavigationContext $context,
        NavigationCandidate $candidate
    ): float {
        if (blank($context->brandName)) {
            return 0;
        }

        $tokens = $this->normalizer->tokens(
            $context->brandName
        );

        $matches = array_intersect(
            $tokens,
            $candidate->matchedTokens
        );

        return count($matches) * 25;
    }
}
