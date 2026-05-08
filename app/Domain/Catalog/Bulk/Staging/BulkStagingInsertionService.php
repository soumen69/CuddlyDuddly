<?php

namespace App\Domain\Catalog\Bulk\Staging;

use Illuminate\Support\Facades\DB;

class BulkStagingInsertionService
{
    public function insert(int $sellerId, array $compiled, array $validationErrors): int
    {
        return DB::transaction(function () use ($sellerId, $compiled, $validationErrors) {

            $batchId = DB::table('ingestion_batches')->insertGetId([
                'seller_id' => $sellerId,
                'status' => 'review_required',
                'total_products' => count($compiled['products']),
                'total_errors' => count($validationErrors),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($compiled['products'] as $productBlock) {

                $product = $productBlock['product'];

                $ingestionProductId = DB::table('ingestion_products')->insertGetId([
                    'batch_id' => $batchId,
                    'status' => $this->resolveProductStatus(
                        $product,
                        $productBlock,
                        $validationErrors
                    ),
                    'product_code' => $product['group_code'],
                    'category_id' => $product['category_id'] ?? null,
                    'raw_payload' => json_encode($product),
                    'compiled_payload' => json_encode($productBlock),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($productBlock['variants'] as $variant) {

                    DB::table('ingestion_variants')->insert([
                        'ingestion_product_id' => $ingestionProductId,
                        'variant_key' => $variant['variant_key'],
                        'payload' => json_encode($variant),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            foreach ($validationErrors as $error) {

                DB::table('ingestion_errors')->insert([
                    'batch_id' => $batchId,
                    'product_code' => $error['product_code']
                        ?? $error['group_code']
                        ?? 'UNKNOWN',
                    'message' => $error['message'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return $batchId;
        });
    }

    protected function resolveProductStatus(
        array $product,
        array $productBlock,
        array $validationErrors
    ): string {

        if (
            ($productBlock['compile_status'] ?? null)
            === 'failed'
        ) {
            return 'compile_failed';
        }

        foreach ($validationErrors as $error) {

            $code =
                $error['product_code']
                ?? $error['group_code']
                ?? null;

            if (
                $code === $product['group_code']
            ) {

                return 'validation_failed';
            }
        }

        return 'pending_review';
    }
}
