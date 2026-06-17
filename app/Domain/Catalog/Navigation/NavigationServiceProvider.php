<?php

namespace App\Domain\Catalog\Navigation;

use Illuminate\Support\ServiceProvider;

use App\Domain\Catalog\Navigation\Contracts\MetadataExtractorInterface;
use App\Domain\Catalog\Navigation\Contracts\NavigationCandidateDiscoveryInterface;
use App\Domain\Catalog\Navigation\Contracts\NavigationIndexRepositoryInterface;
use App\Domain\Catalog\Navigation\Contracts\NavigationPlacementEngineInterface;
use App\Domain\Catalog\Navigation\Contracts\NavigationScorerInterface;
use App\Domain\Catalog\Navigation\Contracts\PlacementBuilderInterface;
use App\Domain\Catalog\Navigation\Contracts\ProductCategorySectionRepositoryInterface;

use App\Domain\Catalog\Navigation\Services\MetadataExtractor;
use App\Domain\Catalog\Navigation\Services\NavigationCandidateDiscovery;
use App\Domain\Catalog\Navigation\Services\NavigationPlacementEngine;
use App\Domain\Catalog\Navigation\Services\NavigationScorer;

use App\Domain\Catalog\Navigation\Builders\PlacementBuilder;

use App\Domain\Catalog\Navigation\Repositories\NavigationIndexRepository;
use App\Domain\Catalog\Navigation\Repositories\ProductCategorySectionRepository;

class NavigationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            NavigationPlacementEngineInterface::class,
            NavigationPlacementEngine::class
        );

        $this->app->bind(
            MetadataExtractorInterface::class,
            MetadataExtractor::class
        );

        $this->app->bind(
            PlacementBuilderInterface::class,
            PlacementBuilder::class
        );

        $this->app->bind(
            NavigationCandidateDiscoveryInterface::class,
            NavigationCandidateDiscovery::class
        );

        $this->app->bind(
            NavigationScorerInterface::class,
            NavigationScorer::class
        );

        $this->app->bind(
            ProductCategorySectionRepositoryInterface::class,
            ProductCategorySectionRepository::class
        );

        $this->app->bind(
            NavigationIndexRepositoryInterface::class,
            NavigationIndexRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
