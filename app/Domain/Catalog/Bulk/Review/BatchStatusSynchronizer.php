<?php

namespace App\Domain\Catalog\Bulk\Review;

use Illuminate\Support\Facades\DB;

class BatchStatusSynchronizer
{
    public function sync(
        int $batchId
    ): void {

        $products = DB::table(
            'ingestion_products'
        )
            ->where('batch_id', $batchId)
            ->get();

        if ($products->isEmpty()) {

            return;
        }

        $hasFailures = $products->contains(
            fn($p) => in_array(
                $p->status,
                [
                    'compile_failed',
                    'validation_failed',
                    'rejected',
                ]
            )
        );

        $hasPending = $products->contains(
            fn($p) => $p->status === 'pending_review'
        );

        $allApproved = $products->every(
            fn($p) => $p->status === 'approved'
        );

        $status = match (true) {

            $hasFailures => 'review_required',

            $hasPending => 'review_required',

            $allApproved => 'ready_for_commit',

            default => 'review_required',
        };

        DB::table('ingestion_batches')

            ->where('id', $batchId)

            ->update([

                'status' => $status,

                'updated_at' => now(),
            ]);
    }
}
