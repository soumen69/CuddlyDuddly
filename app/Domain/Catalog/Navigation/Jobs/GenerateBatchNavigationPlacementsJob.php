<?php

namespace App\Domain\Catalog\Navigation\Jobs;

use App\Models\Products;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Domain\Catalog\Navigation\Contracts\NavigationPlacementEngineInterface;

class GenerateBatchNavigationPlacementsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $timeout = 1800;

    public int $tries = 3;

    public function __construct(
        public readonly int $batchId
    ) {
    }

    public function handle(
        NavigationPlacementEngineInterface $engine
    ): void {

        Products::query()

            ->where(
                'bulk_batch_id',
                $this->batchId
            )

            ->chunkById(
                100,
                function ($products) use ($engine) {

                    foreach ($products as $product) {

                        try {

                            $engine->generate(
                                $product
                            );
                        } catch (\Throwable $e) {

                            report($e);

                            continue;
                        }
                    }
                }
            );
    }
}