<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Domain\Catalog\Bulk\Images\BulkImageZipProcessor;

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

    public function downloadZipTemplate(
        int $batchId
    ) {

        $products = DB::table('products')
            ->where('seller_id', 1)
            ->latest('id')
            ->get();

        $tempPath = storage_path(
            'app/temp/bulk-image-template-' . $batchId . '.zip'
        );

        if (!file_exists(dirname($tempPath))) {

            mkdir(dirname($tempPath), 0777, true);
        }

        $zip = new ZipArchive();

        $zip->open(
            $tempPath,
            ZipArchive::CREATE | ZipArchive::OVERWRITE
        );

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

            /*
            |--------------------------------------------------------------------------
            | SIMPLE PRODUCT
            |--------------------------------------------------------------------------
            */

            if ($variantValues->isEmpty()) {

                $folder =
                    $product->product_code . '/';

                $zip->addEmptyDir($folder);

                for ($i = 1; $i <= 4; $i++) {

                    $zip->addFromString(
                        $folder . $i . '.jpg',
                        ''
                    );
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | VISUAL VARIANT PRODUCT
            |--------------------------------------------------------------------------
            */

            foreach ($variantValues as $value) {

                $folder =
                    $product->product_code
                    . '/'
                    . $value->value
                    . '/';

                $zip->addEmptyDir($folder);

                for ($i = 1; $i <= 4; $i++) {

                    $zip->addFromString(
                        $folder . $i . '.jpg',
                        ''
                    );
                }
            }
        }

        $zip->close();

        return response()->download(
            $tempPath,
            'bulk-image-template-' . $batchId . '.zip'
        )->deleteFileAfterSend();
    }

    public function manual(int $batchId)
    {
        $products = DB::table('products')

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

        return view(
            'admin.bulk.images.manual',
            compact(
                'products',
                'batchId'
            )
        );
    }

    public function uploadZip(
        Request $request,
        int $batchId,
        BulkImageZipProcessor $processor
    ) {

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

        return back()->with(

            'success',

            $result['inserted']
                . ' images staged successfully.'
        );
    }
}
