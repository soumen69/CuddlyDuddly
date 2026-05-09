<?php

namespace App\Domain\Catalog\Bulk\Images;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\ProductImage;
use App\Models\ProductAttributeValueImage;

class BulkImageCommitEngine
{
    public function commit(
        int $batchId
    ): array {

        $images = DB::table(
            'ingestion_product_images'
        )

            ->where(
                'batch_id',
                $batchId
            )

            ->where(
                'status',
                'pending_review'
            )

            ->orderBy('product_id')

            ->orderBy('sort_order')

            ->get();

        $inserted = 0;

        foreach ($images as $image) {

            DB::transaction(function () use (
                $image,
                &$inserted
            ) {

                $newPath =
                    $this->moveImageToFinalLocation(
                        $image
                    );

                /*
                |--------------------------------------------------------------------------
                | SIMPLE PRODUCT
                |--------------------------------------------------------------------------
                */

                if (
                    $image->image_type
                    ===
                    'simple'
                ) {

                    ProductImage::create([

                        'product_id' =>
                        $image->product_id,

                        'image_path' =>
                        $newPath,

                        'is_primary' =>
                        $image->is_primary,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | VISUAL VARIANT
                |--------------------------------------------------------------------------
                */ else {

                    ProductAttributeValueImage::create([

                        'product_id' =>
                        $image->product_id,

                        'attribute_value_id' =>
                        $image->attribute_value_id,

                        'image_path' =>
                        $newPath,

                        'is_primary' =>
                        $image->is_primary,

                        'sort_order' =>
                        $image->sort_order,
                    ]);
                }

                DB::table(
                    'ingestion_product_images'
                )

                    ->where(
                        'id',
                        $image->id
                    )

                    ->update([

                        'status' =>
                        'committed',

                        'updated_at' =>
                        now(),
                    ]);

                $inserted++;

                $this->syncProductImageStatus(
                    $image->product_id
                );
            });
        }

        return [

            'inserted' => $inserted,
        ];
    }

    protected function moveImageToFinalLocation(
        object $image
    ): string {

        $ext = pathinfo(
            $image->image_path,
            PATHINFO_EXTENSION
        );

        $folder =
            $image->image_type === 'simple'
            ? 'products/' . date('Y/m')
            : 'products/variants/' . date('Y/m');

        $newPath =
            $folder
            . '/'
            . uniqid()
            . '.'
            . $ext;

        Storage::disk('public')->copy(
            $image->image_path,
            $newPath
        );

        return $newPath;
    }

    protected function syncProductImageStatus(
        int $productId
    ): void {

        $simpleCount = ProductImage::where(
            'product_id',
            $productId
        )->count();

        $variantCount =
            ProductAttributeValueImage::where(
                'product_id',
                $productId
            )->count();

        $total = $simpleCount + $variantCount;

        DB::table('products')

            ->where('id', $productId)

            ->update([

                'image_upload_status' =>
                $total > 0
                    ? 'completed'
                    : 'pending',
            ]);
    }
}
