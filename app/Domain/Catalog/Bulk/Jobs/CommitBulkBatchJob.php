<?php

namespace App\Domain\Catalog\Bulk\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Domain\Catalog\Bulk\Commit\BulkCommitEngine;

class CommitBulkBatchJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $batchId
    ) {}

    public function handle(
        BulkCommitEngine $engine
    ): void {

        $engine->commitBatch(
            $this->batchId
        );
    }
}
