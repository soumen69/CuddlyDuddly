<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Catalog\Bulk\Images\BulkImageCommitEngine;
use App\Domain\Catalog\Bulk\Images\BulkImageZipProcessor;
use App\Http\Controllers\Controller;
use App\Models\ProductAttributeValueImage;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class BulkImageController extends Controller
{
    public function gateway(int $batchId)
    {
        $batch = DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->first();

        abort_if(! $batch, 404);

        return view(
            'admin.bulk.images.gateway',
            compact('batch')
        );
    }

    public function downloadZipTemplate(
        int $batchId
    ) {

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
            .'/bulk-image-template-'
            .$batchId
            .'.zip';

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
                    $product->product_code.'/';

                $zip->addEmptyDir($folder);

                $zip->addFromString(

                    $folder
                        .'PLACE_IMAGES_HERE.txt',

                    'Replace this file with minimum 4 images.'
                );

                continue;
            }

            foreach ($visualValues as $value) {

                $folder =
                    $product->product_code
                    .'/'
                    .$value->value
                    .'/';

                $zip->addEmptyDir($folder);

                $zip->addFromString(

                    $folder
                        .'PLACE_IMAGES_HERE.txt',

                    'Replace this file with minimum 4 images.'
                );
            }
        }

        $zip->close();

        return response()->download(
            $tempPath
        );
    }

    public function manual(int $batchId)
    {
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
                        .' - '
                        .$product->name,
                ];

                continue;
            }

            foreach ($visualValues as $value) {

                $products[] = [

                    'type' => 'visual_variant',

                    'product_id' => $product->id,

                    'attribute_value_id' => $value->id,

                    'label' => $product->product_code
                        .' - '
                        .$product->name
                        .' - '
                        .$value->value,
                ];
            }
        }

        return view(
            'admin.bulk.images.manual',
            compact(
                'products',
                'batchId'
            )
        );
    }

    public function uploadZip(Request $request, int $batchId, BulkImageZipProcessor $processor)
    {

        $request->validate([

            'zip' => [
                'required',
                'file',
                'mimes:zip',
            ],
        ]);

        $result = $processor->process(

            $batchId,

            $request->file('zip')->getRealPath()
        );

        return redirect()->route(
            'admin.bulk.images.review',
            $batchId
        )->with(
            'success',
            $result['inserted']
                .' images staged successfully.'
        );
    }

    public function review(int $batchId)
    {
        $images = DB::table(
            'ingestion_product_images'
        )

            ->where(
                'batch_id',
                $batchId
            )

            ->orderBy('product_code')

            ->orderBy('sort_order')

            ->get();

        return view(
            'admin.bulk.images.review',
            compact(
                'images',
                'batchId'
            )
        );
    }

    public function commitImages(int $batchId, BulkImageCommitEngine $engine)
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

        DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->update([

                'status' => 'image_completed',

                'updated_at' => now(),
            ]);

        return redirect()

            ->route('admin.bulk.batches.index')

            ->with(
                'success',
                $result['inserted']
                    .' images committed successfully.'
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
                    ? 'products/variants/'.date('Y/m')
                    : 'products/'.date('Y/m'),

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

        $this->syncBatchImageStatus(
            $product->bulk_batch_id
        );

        return response()->json([

            'success' => true,

            'message' => 'Images uploaded successfully.',
        ]);
    }

    protected function syncBatchImageStatus(int $batchId): void
    {

        $products = Products::query()

            ->where(
                'bulk_batch_id',
                $batchId
            )

            ->get();

        $allCompleted =
            $products->every(
                fn ($p) => $p->image_upload_status === 'completed'
            );

        $hasCompleted =
            $products->contains(
                fn ($p) => $p->image_upload_status === 'completed'
            );

        DB::table('ingestion_batches')

            ->where('id', $batchId)

            ->update([
                'status' => $allCompleted
                ? 'image_completed'
                : (
                    $hasCompleted
                    ? 'image_upload_in_progress'
                    : 'image_upload_pending'
                ),

                'updated_at' => now(),
            ]);
    }

    public function skipForNow(
        int $batchId
    ) {

        DB::table('ingestion_batches')

            ->where('id', $batchId)

            ->update([

                'status' => 'image_upload_pending',

                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.bulk.batches.index')
            ->with(
                'success',
                'You can resume image upload anytime.'
            );
    }
}
