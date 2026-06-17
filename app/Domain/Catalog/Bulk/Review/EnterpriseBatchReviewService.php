<?php

namespace App\Domain\Catalog\Bulk\Review;

use Illuminate\Support\Facades\DB;
use App\Domain\Catalog\Bulk\Review\BatchStatusSynchronizer;

class EnterpriseBatchReviewService
{
    public function batchSummary(int $batchId): array
    {
        return [

            'products' => DB::table('ingestion_products')
                ->where('batch_id', $batchId)
                ->count(),

            'variants' => DB::table('ingestion_variants')
                ->whereIn('ingestion_product_id', function ($q) use ($batchId) {

                    $q->select('id')
                        ->from('ingestion_products')
                        ->where('batch_id', $batchId);
                })->count(),

            'product_errors' => DB::table('ingestion_errors')
                ->where('batch_id', $batchId)
                ->where('product_code', '!=', 'UNKNOWN')
                ->count(),

            'batch_errors' => DB::table('ingestion_errors')
                ->where('batch_id', $batchId)
                ->where('product_code', 'UNKNOWN')
                ->count(),
        ];
    }

    public function markProductApproved(
        int $id
    ) {

        DB::transaction(function () use ($id) {

            $product = DB::table('ingestion_products')
                ->where('id', $id)
                ->lockForUpdate()
                ->first();

            if (!$product) {

                abort(404);
            }

            if (
                in_array($product->status, [
                    'compile_failed',
                    'validation_failed',
                    'rejected',
                ])
            ) {

                throw new \Exception(
                    'This product cannot be approved.'
                );
            }

            $hasErrors = DB::table('ingestion_errors')

                ->where('batch_id', $product->batch_id)

                ->where(
                    'product_code',
                    $product->product_code
                )

                ->exists();

            if ($hasErrors) {

                throw new \Exception(
                    'Resolve product errors before approval.'
                );
            }

            DB::table('ingestion_products')

                ->where('id', $id)

                ->update([

                    'status' => 'approved',

                    'updated_at' => now(),
                ]);

            app(
                BatchWorkflowManager::class
            )->syncReviewState(
                $product->batch_id
            );
        });
    }

    public function rejectProduct(
        int $id,
        string $reason
    ) {

        $product = DB::table(
            'ingestion_products'
        )

            ->where('id', $id)

            ->first();

        if (!$product) {

            abort(404);
        }

        DB::table('ingestion_products')

            ->where('id', $id)

            ->update([

                'status' => 'rejected',

                'updated_at' => now(),
            ]);

        DB::table('ingestion_errors')->insert([

            'batch_id' =>
            $product->batch_id,

            'product_code' =>
            $product->product_code,

            'message' => $reason,

            'created_at' => now(),

            'updated_at' => now(),
        ]);

        app(
            BatchWorkflowManager::class
        )->syncReviewState(
            $product->batch_id
        );
    }

    public function canCommitBatch(
        int $batchId
    ): array {

        $blocked = DB::table('ingestion_products')

            ->where('batch_id', $batchId)

            ->whereIn('status', [
                'pending_review',
                'rejected',
                'compile_failed',
                'validation_failed',
            ])

            ->exists();

        if ($blocked) {

            return [

                'allowed' => false,

                'message' =>
                'Resolve all product reviews before commit.',
            ];
        }

        $batchErrors = DB::table(
            'ingestion_errors'
        )

            ->where('batch_id', $batchId)

            ->where('product_code', 'UNKNOWN')

            ->exists();

        if ($batchErrors) {

            return [

                'allowed' => false,

                'message' =>
                'Batch contains unresolved system errors.',
            ];
        }

        return [

            'allowed' => true,

            'message' => null,
        ];
    }
}
