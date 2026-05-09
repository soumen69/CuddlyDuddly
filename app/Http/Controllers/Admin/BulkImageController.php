<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Domain\Catalog\Bulk\Images\BulkImageZipProcessor;
use App\Domain\Catalog\Bulk\Images\BulkImageCommitEngine;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;
use App\Models\ProductImage;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValueImage;

class BulkImageController extends Controller
{
    public function gateway(int $batchId)
    {
        $batch = DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->first();

        abort_if(!$batch, 404);

        return view(
            'admin.bulk.images.gateway',
            compact('batch')
        );
    }

    public function downloadZipTemplate(int $batchId)
    {
        $products = DB::table('products')
            ->where('seller_id', 1)
            ->latest('id')
            ->get();

        $tempDir = storage_path(
            'app/temp'
        );

        if (!file_exists($tempDir)) {

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

        $zip = new ZipArchive();

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

            $variantValues = DB::table(
                'variant_attribute_values as vav'
            )

                ->join(
                    'attribute_values as av',
                    'vav.attribute_value_id',
                    '=',
                    'av.id'
                )

                ->join(
                    'attributes as a',
                    'av.attribute_id',
                    '=',
                    'a.id'
                )

                ->join(
                    'product_variants as pv',
                    'vav.variant_id',
                    '=',
                    'pv.id'
                )

                ->where(
                    'pv.product_id',
                    $product->id
                )

                ->where(
                    'a.is_visual',
                    1
                )

                ->select(
                    'av.id',
                    'av.value'
                )

                ->distinct()

                ->get();

            if ($variantValues->isEmpty()) {

                $folder =
                    $product->product_code . '/';

                $zip->addEmptyDir($folder);

                $zip->addFromString(

                    $folder
                        . 'PLACE_IMAGES_HERE.txt',

                    'Replace this file with minimum 4 images.'
                );

                continue;
            }

            foreach ($variantValues as $value) {

                $folder =
                    $product->product_code
                    . '/'
                    . $value->value
                    . '/';

                $zip->addEmptyDir($folder);

                $zip->addFromString(

                    $folder
                        . 'PLACE_IMAGES_HERE.txt',

                    'Replace this file with minimum 4 images.'
                );
            }
        }

        $zip->close();

        clearstatcache();

        if (!file_exists($tempPath)) {

            abort(
                500,
                'ZIP file creation failed.'
            );
        }

        return response()->download(
            $tempPath
        );
    }

    public function manual(int $batchId)
    {
        $products = [];
        $baseProducts = Products::query()

            ->where(
                'seller_id',
                1
            )

            ->where(
                'image_upload_status',
                '!=',
                'completed'
            )

            ->get();

        foreach ($baseProducts as $product) {

            $visualValues = DB::table(
                'variant_attribute_values as vav'
            )

                ->join(
                    'attribute_values as av',
                    'vav.attribute_value_id',
                    '=',
                    'av.id'
                )

                ->join(
                    'attributes as a',
                    'av.attribute_id',
                    '=',
                    'a.id'
                )

                ->join(
                    'product_variants as pv',
                    'vav.variant_id',
                    '=',
                    'pv.id'
                )

                ->where(
                    'pv.product_id',
                    $product->id
                )

                ->where(
                    'a.is_visual',
                    1
                )

                ->select(
                    'av.id',
                    'av.value'
                )
                ->distinct()
                ->get();

            if ($visualValues->isEmpty()) {

                $products[] = [

                    'type' => 'simple',

                    'product_id' =>
                    $product->id,

                    'attribute_value_id' =>
                    null,

                    'label' =>

                    $product->product_code
                        . ' - '
                        . $product->name,
                ];

                continue;
            }

            foreach ($visualValues as $value) {

                $products[] = [

                    'type' =>
                    'visual_variant',

                    'product_id' =>
                    $product->id,

                    'attribute_value_id' =>
                    $value->id,

                    'label' =>

                    $product->product_code
                        . ' - '
                        . $product->name
                        . ' - '
                        . $value->value,
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
                'mimes:zip'
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
                . ' images staged successfully.'
        );
    }

    public function review(
        int $batchId
    ) {

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

    public function commitImages(
        int $batchId,
        BulkImageCommitEngine $engine
    ) {

        $result = $engine->commit(
            $batchId
        );

        return redirect()

            ->route('admin.products.index')

            ->with(
                'success',
                $result['inserted']
                    . ' images committed successfully.'
            );
    }


    public function productDetails(
        int $productId
    ) {

        $product = Products::findOrFail(
            $productId
        );

        $visualValues = DB::table(
            'variant_attribute_values as vav'
        )

            ->join(
                'attribute_values as av',
                'vav.attribute_value_id',
                '=',
                'av.id'
            )

            ->join(
                'attributes as a',
                'av.attribute_id',
                '=',
                'a.id'
            )

            ->join(
                'product_variants as pv',
                'vav.variant_id',
                '=',
                'pv.id'
            )

            ->where(
                'pv.product_id',
                $productId
            )

            ->where(
                'a.is_visual',
                1
            )

            ->select(
                'av.id',
                'av.value'
            )

            ->distinct()

            ->get();

        return response()->json([

            'product' => [

                'id' => $product->id,

                'name' => $product->name,

                'product_code' =>
                $product->product_code,
            ],

            'type' =>

            $visualValues->count()
                ? 'visual_variant'
                : 'simple',

            'visual_values' =>
            $visualValues,
        ]);
    }

    public function ajaxUpload(
        Request $request
    ) {

        $request->validate([

            'product_id' => [
                'required',
                'exists:products,id'
            ],

            'images' => [
                'required',
                'array',
                'min:4'
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5000'
            ],
        ]);

        $product = Products::findOrFail(
            $request->product_id
        );

        $attributeValueId =
            $request->attribute_value_id;

        if (!$attributeValueId) {

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
            $request->file('images')
            as $index => $image
        ) {

            $path = $image->store(

                $attributeValueId
                    ? 'products/variants/' . date('Y/m')
                    : 'products/' . date('Y/m'),

                'public'
            );

            if (!$attributeValueId) {

                ProductImage::create([

                    'product_id' =>
                    $product->id,

                    'image_path' =>
                    $path,

                    'is_primary' =>
                    $index === 0 ? 1 : 0,
                ]);
            } else {

                ProductAttributeValueImage::create([

                    'product_id' =>
                    $product->id,

                    'attribute_value_id' =>
                    $attributeValueId,

                    'image_path' =>
                    $path,

                    'is_primary' =>
                    $index === 0 ? 1 : 0,

                    'sort_order' =>
                    $index,
                ]);
            }
        }

        DB::table('products')

            ->where(
                'id',
                $product->id
            )

            ->update([

                'image_upload_status' =>
                'completed',
            ]);

        return response()->json([

            'success' => true,

            'message' =>
            'Images uploaded successfully.',
        ]);
    }
}
