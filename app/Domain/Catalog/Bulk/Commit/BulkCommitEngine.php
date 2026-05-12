<?php

namespace App\Domain\Catalog\Bulk\Commit;

use Illuminate\Support\Facades\DB;

use App\Models\Products;
use App\Models\ProductVariant;
use App\Models\ProductAttributeValue;
use App\Models\VariantAttributeValue;

use App\Domain\Catalog\Bulk\Support\BulkSkuGenerator;

class BulkCommitEngine
{
    protected BulkSkuGenerator $sku;

    public function __construct(
        BulkSkuGenerator $sku
    ) {
        $this->sku = $sku;
    }

    public function commitBatch(
        int $batchId
    ): void {

        $products = DB::table(
            'ingestion_products'
        )

            ->where('batch_id', $batchId)

            ->where('status', 'approved')

            ->get();

        foreach ($products as $staged) {

            DB::transaction(function () use (
                $staged,
                $batchId
            ) {

                if (
                    Products::where(
                        'product_code',
                        $staged->product_code
                    )->exists()
                ) {
                    return;
                }

                $compiled = json_decode(
                    $staged->compiled_payload,
                    true
                );

                $this->commitProductFamily(
                    $compiled,
                    $batchId
                );
            });
        }


        DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->update([
                'status' => 'image_upload_pending',
                'updated_at' => now(),
            ]);
    }

    protected function commitProductFamily(
        array $compiled,
        int $batchId
    ): void {

        $productData =
            $compiled['product'];

        $variants =
            $compiled['variants'];

        $isVariantProduct =
            $productData['is_variant_product']
            ?? false;

        $product = Products::create([

            'product_code' =>
            $productData['group_code'],

            'product_categories_id' =>
            $productData['category_id'],

            'product_sub_categories_id' =>
            $productData['subcategory_id'],

            'seller_id' =>
            $productData['seller_id'] ?? null,

            'brand_id' =>
            $productData['brand_id'] ?? null,

            'name' =>
            $productData['name'],

            'description' =>
            $productData['description'],

            'slug' =>
            $this->sku->slug(
                $productData['name']
            ),

            'sku' =>
            $this->sku->productSku(
                $productData['name']
            ),


            'price' =>
            collect($variants)
                ->min('price'),

            'stock' =>
            collect($variants)
                ->sum('stock'),

            'status' => 1,

            'bulk_batch_id' => $batchId,

            'image_upload_status' => 'pending',
        ]);

        foreach (
            $compiled['simple_attributes']
                ?? []
            as $valueId
        ) {

            ProductAttributeValue::create([

                'product_id' =>
                $product->id,

                'attribute_value_id' =>
                $valueId,
            ]);
        }

        if ($isVariantProduct) {

            foreach ($variants as $variantData) {

                $variantLabels =
                    $this->extractVariantLabels(
                        $variantData['variant_attribute_value_ids']
                    );

                $variant = ProductVariant::create([

                    'product_id' =>
                    $product->id,

                    'sku' =>
                    $this->sku->variantSku(
                        $product->product_code,
                        $variantLabels
                    ),

                    'price' =>
                    $variantData['price'],

                    'stock' =>
                    $variantData['stock'],

                    'status' =>
                    $variantData['status'],
                ]);

                foreach (
                    $variantData['variant_attribute_value_ids']
                    as $valueId
                ) {

                    VariantAttributeValue::create([

                        'variant_id' =>
                        $variant->id,

                        'attribute_value_id' =>
                        $valueId,
                    ]);
                }
            }
        }
    }

    protected function extractVariantLabels(
        array $valueIds
    ): array {

        return DB::table(
            'attribute_values'
        )

            ->whereIn('id', $valueIds)

            ->pluck('value')

            ->toArray();
    }
}
