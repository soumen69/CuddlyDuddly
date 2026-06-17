<?php

namespace App\Domain\Catalog\Bulk\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Domain\Catalog\Bulk\Commit\BulkCommitEngine;
use Illuminate\Support\Facades\DB;
use App\Domain\Catalog\Bulk\Review\BatchWorkflowManager;

class CommitBulkBatchJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $batchId
    ) {}

    // public function handle(
    //     BulkCommitEngine $engine
    // ): void {

    //     try {

    //         $engine->commitBatch(
    //             $this->batchId
    //         );
    //     } catch (\Throwable $e) {

    //         DB::table('ingestion_batches')

    //             ->where(
    //                 'id',
    //                 $this->batchId
    //             )

    //             ->update([

    //                 'status' =>
    //                 'commit_failed',

    //                 'updated_at' =>
    //                 now(),
    //             ]);

    //         report($e);

    //         throw $e;
    //     }
    // }


    public function handle(BulkCommitEngine $engine, BatchWorkflowManager $workflow): void
    {
        try {

            $engine->commitBatch(
                $this->batchId
            );

            $workflow->publishingCompleted(
                $this->batchId
            );
        } catch (\Throwable $e) {

            $workflow->publishingFailed(
                $this->batchId
            );

            report($e);

            throw $e;
        }
    }
}
