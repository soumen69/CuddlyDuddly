<?php

namespace App\Domain\Catalog\Bulk\Images;

use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BulkImageZipProcessor
{
    protected array $allowedExtensions = [
        'jpg',
        'jpeg',
        'png',
        'webp',
    ];

    public function process(
        int $batchId,
        string $zipPath
    ): array {

        $extractPath = storage_path(
            'app/temp/bulk-images/' . uniqid()
        );

        if (!file_exists($extractPath)) {

            mkdir($extractPath, 0777, true);
        }

        $zip = new ZipArchive();

        $zip->open($zipPath);

        $zip->extractTo($extractPath);

        $zip->close();

        $errors = [];
        $inserted = 0;

        $products = scandir($extractPath);

        foreach ($products as $productFolder) {

            if (
                in_array($productFolder, ['.', '..'])
            ) {
                continue;
            }

            $product = DB::table('products')

                ->where(
                    'product_code',
                    $productFolder
                )

                ->first();

            if (!$product) {

                $errors[] = [
                    'product' => $productFolder,
                    'message' => 'Unknown product code.',
                ];

                continue;
            }

            $fullPath =
                $extractPath
                . '/'
                . $productFolder;

            $children = scandir($fullPath);

            /*
            |--------------------------------------------------------------------------
            | SIMPLE PRODUCT
            |--------------------------------------------------------------------------
            */

            $hasNestedFolder = false;

            foreach ($children as $child) {

                if (
                    $child !== '.'
                    &&
                    $child !== '..'
                    &&
                    is_dir($fullPath . '/' . $child)
                ) {

                    $hasNestedFolder = true;
                }
            }

            if (!$hasNestedFolder) {

                $result = $this->processSimpleProduct(
                    $batchId,
                    $product,
                    $fullPath
                );

                $errors = array_merge(
                    $errors,
                    $result['errors']
                );

                $inserted += $result['inserted'];

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | VISUAL VARIANTS
            |--------------------------------------------------------------------------
            */

            foreach ($children as $visualFolder) {

                if (
                    in_array(
                        $visualFolder,
                        ['.', '..']
                    )
                ) {
                    continue;
                }

                $variantPath =
                    $fullPath
                    . '/'
                    . $visualFolder;

                if (!is_dir($variantPath)) {
                    continue;
                }

                $attributeValue = DB::table(
                    'attribute_values'
                )

                    ->whereRaw(
                        'LOWER(value) = ?',
                        [mb_strtolower($visualFolder)]
                    )

                    ->first();

                if (!$attributeValue) {

                    $errors[] = [
                        'product' => $productFolder,
                        'message' =>
                        "Unknown visual folder '{$visualFolder}'",
                    ];

                    continue;
                }

                $result =
                    $this->processVisualVariant(
                        $batchId,
                        $product,
                        $attributeValue,
                        $variantPath
                    );

                $errors = array_merge(
                    $errors,
                    $result['errors']
                );

                $inserted += $result['inserted'];
            }
        }

        return [

            'inserted' => $inserted,

            'errors' => $errors,
        ];
    }

    protected function processSimpleProduct(
        int $batchId,
        object $product,
        string $path
    ): array {

        return $this->storeImages(
            $batchId,
            $product,
            null,
            'simple',
            $path
        );
    }

    protected function processVisualVariant(
        int $batchId,
        object $product,
        object $attributeValue,
        string $path
    ): array {

        return $this->storeImages(
            $batchId,
            $product,
            $attributeValue->id,
            'visual_variant',
            $path
        );
    }

    protected function storeImages(
        int $batchId,
        object $product,
        ?int $attributeValueId,
        string $type,
        string $path
    ): array {

        $errors = [];
        $inserted = 0;

        $files = collect(scandir($path))

            ->filter(function ($file) use ($path) {

                return is_file(
                    $path . '/' . $file
                );
            })

            ->values();

        if (
            $files->count() < 4
        ) {

            $errors[] = [

                'product' =>
                $product->product_code,

                'message' =>
                'Minimum 4 images required.',
            ];

            return [
                'errors' => $errors,
                'inserted' => 0,
            ];
        }

        foreach ($files as $index => $file) {

            $ext = strtolower(
                pathinfo(
                    $file,
                    PATHINFO_EXTENSION
                )
            );

            if (
                !in_array(
                    $ext,
                    $this->allowedExtensions
                )
            ) {

                continue;
            }

            $source =
                $path . '/' . $file;

            $stored =
                'bulk-temp/'
                . uniqid()
                . '.'
                . $ext;

            Storage::disk('public')
                ->put(
                    $stored,
                    file_get_contents($source)
                );

            DB::table(
                'ingestion_product_images'
            )->insert([

                'batch_id' => $batchId,

                'product_id' => $product->id,

                'product_code' =>
                $product->product_code,

                'attribute_value_id' =>
                $attributeValueId,

                'image_path' => $stored,

                'original_filename' => $file,

                'image_type' => $type,

                'is_primary' =>
                $index === 0 ? 1 : 0,

                'sort_order' => $index,

                'status' =>
                'pending_review',

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            $inserted++;
        }

        return [

            'errors' => $errors,

            'inserted' => $inserted,
        ];
    }
}
