<?php

namespace App\Domain\Catalog\Bulk\Review;

use Illuminate\Support\Facades\DB;
use App\Models\Products;

class BatchWorkflowManager
{
    public function syncReviewState(
        int $batchId
    ): void {

        $products = DB::table('ingestion_products')
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

            $allApproved => 'ready_for_publish',

            default => 'review_required',
        };

        $this->setBatchStatus(
            $batchId,
            $status
        );
    }

    public function startPublishing(
        int $batchId
    ): void {

        $this->setBatchStatus(
            $batchId,
            'publishing'
        );
    }

    public function publishingCompleted(
        int $batchId
    ): void {

        $this->setBatchStatus(
            $batchId,
            'image_upload_pending'
        );
    }

    public function publishingFailed(
        int $batchId
    ): void {

        $this->setBatchStatus(
            $batchId,
            'publish_failed'
        );
    }

    public function syncImageState(
        int $batchId
    ): void {

        $products = Products::query()

            ->where(
                'bulk_batch_id',
                $batchId
            )

            ->get();

        if ($products->isEmpty()) {
            return;
        }

        $allCompleted =
            $products->every(
                fn($p) =>
                $p->image_upload_status === 'completed'
            );

        $hasCompleted =
            $products->contains(
                fn($p) =>
                $p->image_upload_status === 'completed'
            );

        $status = match (true) {

            $allCompleted => 'completed',

            $hasCompleted => 'image_upload_in_progress',

            default => 'image_upload_pending',
        };

        $this->setBatchStatus(
            $batchId,
            $status
        );
    }

    public function canReview(
        string $status
    ): bool {

        return in_array(
            $status,
            [
                'review_required',
                'ready_for_publish',
                'publish_failed',
            ]
        );
    }

    public function canPublish(
        string $status
    ): bool {

        return $status === 'ready_for_publish';
    }

    public function canUploadImages(
        string $status
    ): bool {

        return in_array($status, [
            'publishing',
            'image_upload_pending',
            'image_review_required',
            'image_upload_in_progress',
            'completed',
        ]);
    }

    public function isLocked(
        string $status
    ): bool {

        return in_array(
            $status,
            [
                'publishing',
                'completed',
            ]
        );
    }

    protected function setBatchStatus(int $batchId, string $status): void
    {
        DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->update([
                'status' => $status,
                'updated_at' => now(),
            ]);
    }
}
