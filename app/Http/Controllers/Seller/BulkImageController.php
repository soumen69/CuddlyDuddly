<?php

namespace App\Http\Controllers\Seller;

use App\Domain\Catalog\Bulk\Images\BulkImageCommitEngine;
use App\Domain\Catalog\Bulk\Images\BulkImageZipProcessor;
use App\Http\Controllers\Controller;
use App\Models\ProductAttributeValueImage;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\Sellers;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use App\Domain\Catalog\Bulk\Review\BatchWorkflowManager;
use Illuminate\Pagination\LengthAwarePaginator;

class BulkImageController extends Controller
{
    public function gateway(Sellers $seller, int $batchId, BatchWorkflowManager $workflow)
    {
        $batch = DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->first();

        abort_if(! $batch, 404);

        abort_unless(
            $workflow->canUploadImages(
                $batch->status
            ),
            403
        );

        return view(
            'seller.bulk.images.gateway',
            compact('batch', 'seller')
        );
    }

    // public function downloadZipTemplate($batchId)
    // {

    //     $batchId = (int) $batchId;
    //     $products = Products::query()

    //         ->with([
    //             'variants.values.attribute',
    //         ])

    //         ->where(
    //             'bulk_batch_id',
    //             $batchId
    //         )

    //         ->latest('id')

    //         ->get();

    //     $tempDir = storage_path(
    //         'app/temp'
    //     );

    //     if (! file_exists($tempDir)) {

    //         mkdir(
    //             $tempDir,
    //             0777,
    //             true
    //         );
    //     }

    //     $tempPath =
    //         $tempDir
    //         . '/bulk-image-template-'
    //         . $batchId
    //         . '.zip';

    //     if (file_exists($tempPath)) {

    //         unlink($tempPath);
    //     }

    //     $zip = new ZipArchive;

    //     $opened = $zip->open(

    //         $tempPath,

    //         ZipArchive::CREATE
    //             | ZipArchive::OVERWRITE
    //     );

    //     if ($opened !== true) {

    //         abort(
    //             500,
    //             'Unable to create ZIP archive.'
    //         );
    //     }

    //     foreach ($products as $product) {

    //         $visualValues = collect();

    //         foreach ($product->variants as $variant) {

    //             foreach ($variant->values as $value) {

    //                 if (
    //                     optional(
    //                         $value->attribute
    //                     )->is_visual
    //                 ) {

    //                     $visualValues->push($value);
    //                 }
    //             }
    //         }

    //         $visualValues =
    //             $visualValues
    //             ->unique('id');

    //         if ($visualValues->isEmpty()) {

    //             $folder =
    //                 $product->product_code . '/';

    //             $zip->addEmptyDir($folder);

    //             $zip->addFromString(

    //                 $folder
    //                     . 'PLACE_IMAGES_HERE.txt',

    //                 'Replace this file with minimum 4 images.'
    //             );

    //             continue;
    //         }

    //         foreach ($visualValues as $value) {

    //             $folder =
    //                 $product->product_code
    //                 . '/'
    //                 . $value->value
    //                 . '/';

    //             $zip->addEmptyDir($folder);

    //             $zip->addFromString(

    //                 $folder
    //                     . 'PLACE_IMAGES_HERE.txt',

    //                 'Replace this file with minimum 4 images.'
    //             );
    //         }
    //     }

    //     $zip->close();

    //     return response()->download(
    //         $tempPath
    //     );
    // }



    public function downloadZipTemplate(Sellers $seller, int $batchId, BatchWorkflowManager $workflow)
    {

        $batch = DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->first();

        abort_if(! $batch, 404);

        abort_unless(
            $workflow->canUploadImages(
                $batch->status
            ),
            403
        );

        $products = Products::query()

            ->with([
                'variants.values.attribute',
            ])

            ->where(
                'bulk_batch_id',
                $batchId
            )

            ->latest('id')

            ->get();

        abort_if(
            $products->isEmpty(),
            404,
            'No committed products found for ZIP template.'
        );

        $tempDir = storage_path(
            'app/temp'
        );

        if (! file_exists($tempDir)) {

            mkdir(
                $tempDir,
                0777,
                true
            );
        }

        $tempPath =
            $tempDir
            . '/bulk-image-template-'
            . $batchId
            . '.zip';

        if (file_exists($tempPath)) {

            unlink($tempPath);
        }

        $zip = new ZipArchive;

        $opened = $zip->open(

            $tempPath,

            ZipArchive::CREATE
                | ZipArchive::OVERWRITE
        );

        if ($opened !== true) {

            abort(
                500,
                'Unable to create ZIP archive.'
            );
        }

        foreach ($products as $product) {

            $visualValues = collect();

            foreach ($product->variants as $variant) {

                foreach ($variant->values as $value) {

                    if (
                        optional(
                            $value->attribute
                        )->is_visual
                    ) {

                        $visualValues->push($value);
                    }
                }
            }

            $visualValues =
                $visualValues
                ->unique('id');

            if ($visualValues->isEmpty()) {

                $folder =
                    $product->product_code . '/';

                $zip->addEmptyDir($folder);

                $zip->addFromString(

                    $folder
                        . 'PLACE_IMAGES_HERE.txt',

                    "Place minimum 4 images here.\nRename banner image as 1.webp or 1.png"
                );

                continue;
            }

            foreach ($visualValues as $value) {

                $folder =
                    $product->product_code
                    . '/'
                    . $value->value
                    . '/';

                $zip->addEmptyDir($folder);

                $zip->addFromString(

                    $folder
                        . 'PLACE_IMAGES_HERE.txt',

                    "Place images for {$value->value} variant here.\nRename banner image as 1.webp or 1.png"
                );
            }
        }

        $zip->close();

        abort_unless(
            file_exists($tempPath),
            500,
            'ZIP template generation failed.'
        );

        return response()->download(
            $tempPath
        )->deleteFileAfterSend(true);
    }

    public function manual(Sellers $seller, int $batchId, BatchWorkflowManager $workflow)
    {

        $batch = DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->first();

        abort_if(! $batch, 404);

        abort_unless(
            $workflow->canUploadImages(
                $batch->status
            ),
            403
        );

        $products = [];

        $baseProducts = Products::query()

            ->with([
                'variants.values.attribute',
            ])

            ->where(
                'bulk_batch_id',
                $batchId
            )

            ->whereIn(
                'image_upload_status',
                [
                    'pending',
                    'skipped',
                    'in_progress',
                ]
            )

            ->get();

        foreach ($baseProducts as $product) {

            $visualValues = collect();

            foreach ($product->variants as $variant) {

                foreach ($variant->values as $value) {

                    if (
                        optional(
                            $value->attribute
                        )->is_visual
                    ) {

                        $visualValues->push($value);
                    }
                }
            }

            $visualValues =
                $visualValues
                ->unique('id');

            if ($visualValues->isEmpty()) {

                $products[] = [

                    'type' => 'simple',

                    'product_id' => $product->id,

                    'attribute_value_id' => null,

                    'label' => $product->product_code
                        . ' - '
                        . $product->name,
                ];

                continue;
            }

            foreach ($visualValues as $value) {

                $products[] = [

                    'type' => 'visual_variant',

                    'product_id' => $product->id,

                    'attribute_value_id' => $value->id,

                    'label' => $product->product_code
                        . ' - '
                        . $product->name
                        . ' - '
                        . $value->value,
                ];
            }
        }

        return view(
            'seller.bulk.images.manual',
            compact(
                'products',
                'batchId',
                'seller'
            )
        );
    }

    public function uploadZip(Sellers $seller, Request $request, BulkImageZipProcessor $processor, int $batchId, BatchWorkflowManager $workflow)
    {

        $request->validate([

            'zip' => [
                'required',
                'file',
                'mimes:zip',
            ],
        ]);

        $batch = DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->first();

        abort_if(! $batch, 404);

        abort_unless(
            $workflow->canUploadImages(
                $batch->status
            ),
            403
        );

        $result = $processor->process($batchId, $request->file('zip')->getRealPath());
        DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->update([
                'status' => 'image_review_required',
                'updated_at' => now(),
            ]);
        return redirect()->route(
            'seller.bulk.images.review',
            [
                'seller' => $seller->slug,
                'batchId' => $batchId,
            ]
        )->with(
            'success',
            $result['inserted']
                . ' images staged successfully.'
        );
    }

    // public function review(Sellers $seller, int $batchId)
    // {
    //     $rawImages = DB::table(
    //         'ingestion_product_images'
    //     )
    //         ->where(
    //             'batch_id',
    //             $batchId
    //         )
    //         ->orderBy('product_code')
    //         ->orderBy('sort_order')
    //         ->get();

    //     $stats = [

    //         'total_images' => $rawImages->count(),

    //         'cover_images' => $rawImages
    //             ->where('is_primary', 1)
    //             ->count(),

    //         'variant_images' => $rawImages
    //             ->where(
    //                 'image_type',
    //                 'visual_variant'
    //             )
    //             ->count(),

    //         'products' => $rawImages
    //             ->pluck('product_code')
    //             ->unique()
    //             ->count(),
    //     ];

    //     $images = $rawImages
    //         ->groupBy('product_code');

    //     return view(
    //         'seller.bulk.images.review',
    //         compact(
    //             'images',
    //             'stats',
    //             'batchId',
    //             'seller'
    //         )
    //     );
    // }



    public function review(Sellers $seller, int $batchId)
    {
        $rawImages = DB::table(
            'ingestion_product_images'
        )
            ->where(
                'batch_id',
                $batchId
            )
            ->orderBy('product_code')
            ->orderBy('attribute_value_id')
            ->orderBy('sort_order')
            ->get();
        $stats = [
            'total_images' => $rawImages->count(),
            'cover_images' => $rawImages
                ->where('is_primary', 1)
                ->count(),
            'variant_images' => $rawImages
                ->where('image_type', 'visual_variant')
                ->count(),
            'products' => $rawImages
                ->pluck('product_code')
                ->unique()
                ->count(),
        ];

        $attributeValues = AttributeValue::with('attribute')
            ->get()
            ->keyBy('id');

        $groupedImages = $rawImages
            ->groupBy('product_code')
            ->map(function ($productImages) use ($attributeValues) {
                $groups = $productImages
                    ->groupBy(fn($image) => $image->attribute_value_id ?: 'simple');
                return [
                    'is_variant_product' => $groups->keys()->filter(fn($k) => $k !== 'simple')->count() > 0,
                    'variant_count' => $groups->keys()->filter(fn($k) => $k !== 'simple')->count(),
                    'groups' => $groups->mapWithKeys(function ($images, $key) use ($attributeValues) {
                        if ($key === 'simple') {
                            return [
                                'simple' => [
                                    'label' => 'Product Images',
                                    'images' => $images
                                ]
                            ];
                        }

                        return [
                            $key => [
                                'label' => $attributeValues[$key]->value ?? 'Unknown',
                                'images' => $images
                            ]
                        ];
                    })
                ];
            });

        $currentPage = request()->integer('page', 1);
        $perPage = 5;
        $pageItems = $groupedImages
            ->slice(
                ($currentPage - 1) * $perPage,
                $perPage
            );
        $images = new LengthAwarePaginator(
            $pageItems,
            $groupedImages->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view(
            'seller.bulk.images.review',
            compact(
                'images',
                'stats',
                'batchId',
                'seller'
            )
        );
    }
    public function commitImages(Sellers $seller, BulkImageCommitEngine $engine, int $batchId, BatchWorkflowManager $workflow)
    {

        $result = $engine->commit(
            $batchId
        );

        $products = Products::query()
            ->where('bulk_batch_id', $batchId)
            ->get();

        foreach ($products as $product) {

            $hasSimpleImages = ProductImage::where(
                'product_id',
                $product->id
            )->exists();

            $hasVariantImages = ProductAttributeValueImage::where(
                'product_id',
                $product->id
            )->exists();

            $product->update([

                'image_upload_status' => ($hasSimpleImages || $hasVariantImages)
                    ? 'completed'
                    : 'pending',
            ]);
        }

        $workflow->syncImageState(
            $batchId
        );

        return redirect()

            ->route('seller.bulk.batches.index', ['seller' => $seller->slug])

            ->with(
                'success',
                $result['inserted']
                    . ' images committed successfully.'
            );
    }

    public function productDetails(int $productId)
    {
        $product = Products::query()
            ->with([
                'variants.values.attribute',
            ])
            ->findOrFail($productId);

        $visualValues = collect();

        foreach ($product->variants as $variant) {

            foreach ($variant->values as $value) {

                if (
                    optional(
                        $value->attribute
                    )->is_visual
                ) {

                    $visualValues->push([
                        'id' => $value->id,
                        'value' => $value->value,
                    ]);
                }
            }
        }

        $visualValues =
            $visualValues
            ->unique('id')
            ->values();

        return response()->json([

            'product' => [

                'id' => $product->id,

                'name' => $product->name,

                'product_code' => $product->product_code,
            ],

            'type' => $visualValues->count()
                ? 'visual_variant'
                : 'simple',

            'visual_values' => $visualValues,
        ]);
    }

    public function ajaxUpload(Request $request)
    {
        $request->validate([

            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'images' => [
                'required',
                'array',
                'min:4',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5000',
            ],
        ]);

        // $product = Products::findOrFail(
        //     $request->product_id
        // );

        $product = Products::query()
            ->with([
                'variants.values.attribute',
            ])
            ->findOrFail(
                $request->product_id
            );

        $attributeValueId = $request->attribute_value_id;

        if (! $attributeValueId) {

            ProductImage::where(
                'product_id',
                $product->id
            )->delete();
        } else {

            ProductAttributeValueImage::where(

                'product_id',
                $product->id

            )->where(

                'attribute_value_id',
                $attributeValueId

            )->delete();
        }

        foreach (
            $request->file('images') as $index => $image
        ) {

            $path = $image->store(

                $attributeValueId
                    ? 'products/variants/' . date('Y/m')
                    : 'products/' . date('Y/m'),

                'public'
            );

            if (! $attributeValueId) {

                ProductImage::create([

                    'product_id' => $product->id,

                    'image_path' => $path,

                    'is_primary' => $index === 0 ? 1 : 0,
                ]);
            } else {

                ProductAttributeValueImage::create([

                    'product_id' => $product->id,

                    'attribute_value_id' => $attributeValueId,

                    'image_path' => $path,

                    'is_primary' => $index === 0 ? 1 : 0,

                    'sort_order' => $index,
                ]);
            }
        }

        $visualAttributeValueIds = collect();

        foreach ($product->variants as $variant) {

            foreach ($variant->values as $value) {

                if (
                    optional($value->attribute)->is_visual
                ) {

                    $visualAttributeValueIds->push(
                        $value->id
                    );
                }
            }
        }

        $visualAttributeValueIds = $visualAttributeValueIds
            ->unique()
            ->values();

        if ($visualAttributeValueIds->isEmpty()) {

            $hasImages = ProductImage::where(
                'product_id',
                $product->id
            )->exists();

            $product->update([
                'image_upload_status' => $hasImages
                    ? 'completed'
                    : 'pending',
            ]);
        } else {

            $uploadedVariantIds =
                ProductAttributeValueImage::where(
                    'product_id',
                    $product->id
                )
                ->distinct()
                ->pluck('attribute_value_id');

            $totalRequired =
                $visualAttributeValueIds->count();

            $totalUploaded =
                $visualAttributeValueIds
                ->intersect($uploadedVariantIds)
                ->count();

            $status = match (true) {

                $totalUploaded === 0 => 'pending',

                $totalUploaded < $totalRequired => 'in_progress',

                default => 'completed',
            };

            $product->update([
                'image_upload_status' => $status,
            ]);
        }

        app(BatchWorkflowManager::class)
            ->syncImageState(
                $product->bulk_batch_id
            );

        return response()->json([

            'success' => true,

            'message' => 'Images uploaded successfully.',
        ]);
    }


    public function skipForNow(
        Sellers $seller,
        int $batchId
    ) {

        DB::table('ingestion_batches')

            ->where('id', $batchId)

            ->update([

                'status' => 'image_upload_pending',

                'updated_at' => now(),
            ]);

        return redirect()
            ->route('seller.bulk.batches.index', ['seller' => $seller->slug])
            ->with(
                'success',
                'You can resume image upload anytime.'
            );
    }
}
