<?php

namespace App\Services\Seller;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Products;
use App\Models\ProductVariant;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;

class ProductVariantImportService
{

    private const TEMPLATE_SHEET = 'Variant Template';
    private const INSTRUCTIONS_SHEET = 'Instructions';

    private const FIXED_COLUMNS = ['SKU', 'Price', 'Stock', 'Status'];
    private const REQUIRED_VIEWS = ['front', 'back', 'top', 'side'];


    private const ALLOWED_IMAGE_EXTENSIONS = ['png', 'svg'];

    public function downloadSample(Request $request, Sellers $seller)
    {
        $this->assertSellerAuthorized($seller);

        $spreadsheet = new Spreadsheet();
        $attributes = Attribute::where('is_active', 1)
            ->with([
                'values' => function ($query) {
                    $query->where('is_active', 1)->select('id', 'attribute_id', 'value');
                }
            ])
            ->get();

        $headers = array_merge($attributes->pluck('name')->all(), self::FIXED_COLUMNS);
        $prefillSkus = $this->extractPrefillSkusFromRequest($request);

        $templateSheet = $spreadsheet->getActiveSheet();
        $templateSheet->setTitle(self::TEMPLATE_SHEET);
        $this->buildTemplateSheet($templateSheet, $attributes, $headers, $prefillSkus);

        $instructionsSheet = $spreadsheet->createSheet();
        $instructionsSheet->setTitle(self::INSTRUCTIONS_SHEET);
        $this->buildInstructionsSheet($instructionsSheet, $seller->slug);

        $spreadsheet->setIndexByName(self::INSTRUCTIONS_SHEET, 0);
        $spreadsheet->setIndexByName(self::TEMPLATE_SHEET, 1);
        $spreadsheet->setActiveSheetIndexByName(self::INSTRUCTIONS_SHEET);

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'variant_template');
        $writer->save($tempFile);

        return response()->download($tempFile, 'variant_template.xlsx')->deleteFileAfterSend(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|max:10240',
            'product_id' => 'required|exists:products,id',
        ]);

        $isPreview = $request->boolean('is_preview');
        $storedImagePaths = [];
        $storedExcelPath = null;

        try {
            if (!$isPreview) {
                DB::beginTransaction();
            }

            $sellerId = Auth::guard('seller')->id();
            $product = Products::where('id', (int) $request->product_id)
                ->where('seller_id', $sellerId)
                ->first();

            if (!$product) {
                throw new \Exception('Invalid product selected for this seller.');
            }

            $imageFilesBySkuView = null;
            $variantImageColumns = $this->resolveVariantImageColumnsForViews(self::REQUIRED_VIEWS);
            $storedImagesBySkuView = [];

            $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
            $templateSheet = $spreadsheet->getSheetByName(self::TEMPLATE_SHEET) ?? $spreadsheet->getSheet(0);
            $rows = $templateSheet->toArray();

            if (count($rows) < 2) {
                throw new \Exception('Excel file is empty.');
            }

            $headers = array_map('trim', array_shift($rows));
            $createdVariants = [];
            $excelSkuKeys = [];
            $excelSkuKeysRequiringImages = [];
            $imageFilesBySkuView = $this->mapUploadedImagesBySkuAndView($request->file('images', []));

            foreach ($rows as $row) {
                if (empty(array_filter($row))) {
                    continue;
                }

                $data = array_combine($headers, $row);
                $rawSku = $this->extractSkuValue($data) ?? '';
                if ($rawSku === '') {
                    continue;
                }
                $sku = trim($rawSku);
                if ($sku === '') {
                    continue;
                }
                $skuBase = $this->normalizeSkuForVariant($sku);
                if ($skuBase === '') {
                    continue;
                }
                $skuKey = $this->canonicalSkuKey($skuBase);
                $excelSkuKeys[$skuKey] = $sku;
                $excelSkuKeys[$this->normalizeSkuForImageMatching($skuBase)] = $sku;

                $lookupSkuKey = $this->resolveImageLookupKey($imageFilesBySkuView, $sku, $skuBase);
                $hasImagesForSku = $lookupSkuKey !== null;

                $matchedImagePaths = [];
                foreach (self::REQUIRED_VIEWS as $view) {
                    $matchedImagePaths[$view] = null;
                }

                $skuRequestedView = $this->extractSkuViewSuffix($sku);

                if ($hasImagesForSku) {
                    $excelSkuKeysRequiringImages[$skuKey] = $skuBase;

                    if (
                        $skuRequestedView !== null
                        && !isset($imageFilesBySkuView[$lookupSkuKey][$skuRequestedView])
                    ) {
                        throw new \Exception(
                            "Image missing for SKU: {$sku}. Required file: {$skuBase}-{$skuRequestedView}."
                        );
                    }

                    if ($skuRequestedView === null) {
                        $missingViews = $this->missingViewsForSku($imageFilesBySkuView, $lookupSkuKey);

                        if (!empty($missingViews)) {
                            throw new \Exception(
                                "Image missing for SKU: {$skuBase}. Required files: {$skuBase}-front, {$skuBase}-back, {$skuBase}-top, {$skuBase}-side."
                            );
                        }
                    }

                    if (!$isPreview && !isset($storedImagesBySkuView[$lookupSkuKey])) {
                        $storedImagesBySkuView[$lookupSkuKey] = $this->storeSkuViewImages(
                            $imageFilesBySkuView[$lookupSkuKey],
                            $skuBase,
                            $storedImagePaths
                        );
                    }

                    foreach (self::REQUIRED_VIEWS as $view) {
                        $matchedImagePaths[$view] = $isPreview
                            ? $imageFilesBySkuView[$lookupSkuKey][$view]->getClientOriginalName()
                            : ($storedImagesBySkuView[$lookupSkuKey][$view] ?? null);
                    }
                }


                $attributesArray = [];
                $attributeValueIds = [];

                foreach ($headers as $header) {
                    if (in_array($header, self::FIXED_COLUMNS, true)) {
                        continue;
                    }

                    if (empty($data[$header])) {
                        continue;
                    }

                    $attributesArray[$header] = $data[$header];

                    if ($isPreview) {
                        continue;
                    }

                    $attribute = Attribute::firstOrCreate(
                        ['name' => $header],
                        ['is_active' => 1]
                    );

                    $attributeValue = AttributeValue::firstOrCreate(
                        ['attribute_id' => $attribute->id, 'value' => $data[$header]],
                        ['is_active' => 1]
                    );

                    $attributeValueIds[] = [
                        'attribute_value_id' => $attributeValue->id,
                        'attribute_id' => $attribute->id,
                    ];
                }

                $variant = null;
                if (!$isPreview) {
                    $variantPayload = [
                        'price' => $this->extractPrice($data),
                        'stock' => $this->extractStock($data),
                        'is_active' => $this->extractStatus($data),
                    ];

                    if ($matchedImagePaths['front'] !== null) {
                        $variantPayload[$variantImageColumns['front']] = $matchedImagePaths['front'];
                        $variantPayload[$variantImageColumns['back']] = $matchedImagePaths['back'];
                        $variantPayload[$variantImageColumns['top']] = $matchedImagePaths['top'];
                        $variantPayload[$variantImageColumns['side']] = $matchedImagePaths['side'];
                    }

                    $variant = ProductVariant::updateOrCreate(
                        ['sku' => $sku, 'product_id' => $product->id],
                        $variantPayload
                    );

                    $variant->attributeValues()->detach();
                    foreach ($attributeValueIds as $item) {
                        $variant->attributeValues()->attach(
                            $item['attribute_value_id'],
                            ['attribute_id' => $item['attribute_id']]
                        );
                    }
                }

                $createdVariants[] = [
                    'id' => $variant?->id,
                    'sku' => $sku,
                    'image' => $isPreview ? $matchedImagePaths['front'] : $variant->{$variantImageColumns['front']},
                    'image_front' => $matchedImagePaths['front'],
                    'image_back' => $matchedImagePaths['back'],
                    'image_top' => $matchedImagePaths['top'],
                    'image_side' => $matchedImagePaths['side'],
                    'price' => $isPreview ? $this->extractPrice($data) : $variant->price,
                    'stock' => $isPreview ? $this->extractStock($data) : $variant->stock,
                    'is_active' => $isPreview ? $this->extractStatus($data) : $variant->is_active,
                    'attributes' => $attributesArray,
                    'base_sku' => $skuBase,
                    'group_key' => $this->canonicalSkuKey($skuBase),
                ];
            }

            if ($imageFilesBySkuView !== null) {
                foreach ($imageFilesBySkuView as $imageSkuKey => $views) {
                    if (!isset($excelSkuKeys[$imageSkuKey])) {
                        /** @var UploadedFile $sampleViewFile */
                        $sampleViewFile = reset($views);
                        $imageBaseName = pathinfo($sampleViewFile->getClientOriginalName(), PATHINFO_FILENAME);
                        throw new \Exception(
                            "Image set {$imageBaseName} has no matching SKU in Excel."
                        );
                    }
                }
            }

            if (empty($createdVariants)) {
                throw new \Exception('No variant data found in uploaded Excel.');
            }

            if (!$isPreview) {
                $storedExcelPath = $this->storeUploadedExcelFile(
                    $request->file('file'),
                    (int) $sellerId,
                    (int) $product->id
                );
                DB::commit();
            }

            return response()->json([
                'success' => true,
                'mode' => $isPreview ? 'preview' : 'saved',
                'data' => $createdVariants,
            ]);
        } catch (\Exception $e) {
            if (!$isPreview) {
                DB::rollBack();
            }
            if (!$isPreview && !empty($storedImagePaths)) {
                Storage::disk('public')->delete($storedImagePaths);
            }
            if (!$isPreview && $storedExcelPath) {
                Storage::disk('public')->delete($storedExcelPath);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function downloadUploadedExcel(Request $request, Sellers $seller)
    {
        $this->assertSellerAuthorized($seller);

        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $product = $this->resolveOwnedProduct($seller, (int) $request->product_id);
        if (!$product) {
            abort(404, 'Product not found for this seller.');
        }

        $variants = ProductVariant::with('attributeValues.attribute')
            ->where('product_id', $product->id)
            ->orderBy('id')
            ->get();

        if ($variants->isEmpty()) {
            abort(404, 'No uploaded Excel found for this product.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(self::TEMPLATE_SHEET);

        $headers = $this->buildVariantExportHeaders($variants);
        foreach ($headers as $index => $header) {
            $column = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($column . '1', $header);
            $sheet->getStyle($column . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $lastHeaderCol = Coordinate::stringFromColumnIndex(count($headers));
        $sheet->freezePane('A2');
        $sheet->getStyle('A1:' . $lastHeaderCol . '1')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFEFEFEF');

        foreach ($variants as $rowIndex => $variant) {
            $rowNumber = $rowIndex + 2;
            $row = $this->mapVariantForExportRow($variant, $headers);

            foreach ($headers as $columnIndex => $header) {
                $column = Coordinate::stringFromColumnIndex($columnIndex + 1);
                $sheet->setCellValue($column . $rowNumber, $row[$header] ?? '');
            }
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'uploaded_variant_export');
        $writer->save($tempFile);

        $downloadName = Str::slug($product->name ?: ('product-' . $product->id), '-')
            . '-uploaded-variants.xlsx';

        return response()->download($tempFile, $downloadName)->deleteFileAfterSend(true);
    }

    public function downloadUploadedImages(Request $request, Sellers $seller)
    {
        $this->assertSellerAuthorized($seller);

        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $product = $this->resolveOwnedProduct($seller, (int) $request->product_id);
        if (!$product) {
            abort(404, 'Product not found for this seller.');
        }

        $imageColumns = array_values(array_filter(
            ['image', 'image1', 'image2', 'image3', 'image4'],
            fn($column) => $this->hasProductVariantColumn($column)
        ));

        $variants = ProductVariant::where('product_id', $product->id)->orderBy('id')->get();
        $tempZip = tempnam(sys_get_temp_dir(), 'variant_images_');
        $zip = new ZipArchive();

        if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \Exception('Unable to create images zip file.');
        }

        $addedFiles = 0;
        $usedZipNames = [];
        $addedImagePaths = [];

        foreach ($variants as $variant) {
            foreach ($imageColumns as $column) {
                $storedPath = trim((string) ($variant->{$column} ?? ''));
                if ($storedPath === '' || !Storage::disk('public')->exists($storedPath)) {
                    continue;
                }

                if (in_array($storedPath, $addedImagePaths)) {
                    continue;
                }

                $addedImagePaths[] = $storedPath;

                $extension = Str::lower(pathinfo($storedPath, PATHINFO_EXTENSION) ?: 'png');
                $baseName = Str::slug((string) ($variant->sku ?: ('variant-' . $variant->id)), '-');

                $candidateName = $baseName . '-' . $this->resolveImageViewName($column) . '.' . $extension;

                $zipName = $this->makeUniqueZipEntryName($candidateName, $usedZipNames);
                $usedZipNames[] = $zipName;

                $zip->addFile(Storage::disk('public')->path($storedPath), $zipName);

                $addedFiles++;
            }
        }

        $zip->close();

        if ($addedFiles === 0) {
            @unlink($tempZip);
            abort(404, 'No uploaded variant images found for this product.');
        }

        $downloadName = Str::slug($product->name ?: ('product-' . $product->id), '-') . '-uploaded-variant-images.zip';
        return response()->download($tempZip, $downloadName)->deleteFileAfterSend(true);
    }

    public function variantsData(Request $request, Sellers $seller)
    {
        $this->assertSellerAuthorized($seller);

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Products::where('id', (int) $request->product_id)
            ->where('seller_id', $seller->id)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product selected for this seller.',
            ], 422);
        }

        $primaryImageColumn = $this->resolveVariantImageColumn();

        $variants = ProductVariant::with('attributeValues.attribute')
            ->where('product_id', $product->id)
            ->orderBy('id')
            ->get();

        $data = $variants->map(function ($variant) use ($primaryImageColumn) {
            $attributes = [];
            foreach ($variant->attributeValues as $attributeValue) {
                if ($attributeValue->attribute) {
                    $attributes[$attributeValue->attribute->name] = $attributeValue->value;
                }
            }

            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'image' => $variant->{$primaryImageColumn},
                'image1' => $variant->image1,
                'image2' => $variant->image2,
                'image3' => $variant->image3,
                'price' => $variant->price,
                'stock' => $variant->stock,
                'base_sku' => $this->stripSkuViewSuffix($variant->sku) ?: $variant->sku,
                'group_key' => $this->canonicalSkuKey($variant->sku),
                'is_active' => (bool) $variant->is_active,
                'attributes' => $attributes,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function createVariants(Request $request, Sellers $seller)
    {
        $this->assertSellerAuthorized($seller);

        $productId = (int) $request->query('productId');
        $product = $productId > 0 ? $this->resolveOwnedProduct($seller, $productId) : null;
        $hasUploadedExcel = false;
        $hasUploadedImages = false;

        if ($product) {
            $hasUploadedExcel = $this->productHasVariants((int) $product->id);
            $hasUploadedImages = $this->hasUploadedVariantImages((int) $product->id);
        }

        $id = $seller->id;
        return view('seller.products.variants.create', compact(
            'id',
            'seller',
            'hasUploadedExcel',
            'hasUploadedImages'
        ));
    }



    public function toggleVariantStatus(Request $request, Sellers $seller, ProductVariant $variant)
    {
        $this->assertSellerAuthorized($seller);

        $product = Products::where('id', $variant->product_id)
            ->where('seller_id', $seller->id)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized variant.'
            ], 403);
        }

        $requestedStatus = $request->input('is_active');
        $nextStatus = $requestedStatus !== null
            ? (bool) $requestedStatus
            : !$variant->is_active;

        $groupKey = $this->canonicalSkuKey($variant->sku);
        $variantsToUpdate = ProductVariant::where('product_id', $product->id)->get();

        foreach ($variantsToUpdate as $candidate) {
            if ($this->canonicalSkuKey($candidate->sku) !== $groupKey) {
                continue;
            }

            $candidate->is_active = $nextStatus;
            $candidate->save();
        }

        $variant->is_active = $nextStatus;

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $variant->id,
                'is_active' => (bool) $variant->is_active,
                'group_key' => $groupKey,
            ],
        ]);
    }




    private function buildTemplateSheet(Worksheet $sheet, $attributes, array $headers, array $prefillSkus = []): void
    {
        foreach ($headers as $index => $header) {
            $col = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $lastHeaderCol = Coordinate::stringFromColumnIndex(count($headers));
        $sheet->freezePane('A2');
        $sheet->getStyle('A1:' . $lastHeaderCol . '1')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFEFEFEF');

        $sheet->getComment('A1')->getText()->createTextRun(
            "Upload flow:\n"
            . "1) Fill one row per variant.\n"
            . "2) Keep SKU unique.\n"
            . "3) Upload 4 images per SKU: SKU-front, SKU-back, SKU-top, SKU-side (png/svg) if the variant differs visually.\n"
            . "4) If visually identical, image upload is optional for that row.\n"
            . "5) If a required variant option is missing, raise support ticket from Seller > Support."
        );

        foreach ($attributes as $index => $attribute) {
            $values = $attribute->values->pluck('value')->all();
            if (empty($values)) {
                continue;
            }

            $col = Coordinate::stringFromColumnIndex($index + 1);
            $list = implode(',', $values);
            for ($row = 2; $row <= 100; $row++) {
                $validation = $sheet->getCell($col . $row)->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setAllowBlank(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . $list . '"');
                $validation->setShowInputMessage(true);
                $validation->setPromptTitle($attribute->name . ' value');
                $validation->setPrompt('Select from dropdown. If missing, request it in Seller Support.');
            }
        }

        $this->prefillSkuColumnFromImageNames($sheet, $headers, $prefillSkus);
        $this->applySkuValidation($sheet, $headers);
        $this->applyStatusValidation($sheet, $headers);
        $this->applyPriceValidation($sheet, $headers);
        $this->applyStockValidation($sheet, $headers);
    }

    private function buildInstructionsSheet(Worksheet $sheet, string $sellerSlug): void
    {
        $sheet->setCellValue('A1', 'Variant Upload Instructions');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A3', '1. Do not modify column headers.');
        $sheet->setCellValue('A4', '2. SKU must be unique.');
        $sheet->setCellValue('A5', '3. Price must be numeric.');
        $sheet->setCellValue('A6', '4. Stock must be integer.');
        $sheet->setCellValue('A7', '5. Use dropdowns for attribute selection.');
        $sheet->setCellValue('A8', '6. Status: Active or Inactive.');

        $sheet->setCellValue('A10', 'Image Upload Process');
        $sheet->getStyle('A10')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A11', 'Images are mapped automatically based on SKU.');
        $sheet->setCellValue('A12', '7. Upload variant images in png/svg only.');
        $sheet->setCellValue('A13', '8. If the variant requires unique photos, upload exactly 4 image views per SKU: front, back, top, side.');
        $sheet->setCellValue('A14', '9. If images are not needed, skip image upload for that SKU row.');
        $sheet->setCellValue('A15', '10. Filename format: SKU-front, SKU-back, SKU-top, SKU-side (example: BLU-XL-front.png).');
        $sheet->setCellValue('A16', '11. If any variant attribute/value is missing in Sheet 1 dropdowns, create a Seller Support request.');
        $sheet->setCellValue('A17', '12. In support request, share product name, missing attribute name, and required values.');
        $sheet->setCellValue('A18', 'Seller Support URL: ' . route('seller.support.index', ['seller' => $sellerSlug]));

        $sheet->setCellValue('A19', 'Allowed Images');
        $sheet->getStyle('A19')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A20', 'Allowed format: .png or .svg');
        $sheet->setCellValue('A21', 'Filename pattern: SKU-front / SKU-back / SKU-top / SKU-side');
        $sheet->setCellValue('A22', 'Use clear product-only image with plain background and no watermark/text overlay.');

        $this->attachImageIfExists($sheet, 'images/guides/allowed_image.png', 'Allowed Image Example 1', 'A24', 170);
        $this->attachImageIfExists($sheet, 'images/guides/allowed_image2.png', 'Allowed Image Example 2', 'F24', 170);
        $sheet->setCellValue('A42', 'Example images (Allowed)');

        $sheet->setCellValue('A44', 'Not Allowed Images');
        $sheet->getStyle('A44')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A45', 'Not allowed: wrong file type, wrong filename, blurry image, watermark, heavy text, or unrelated image.');

        if ($this->attachImageIfExists($sheet, 'images/guides/notallow_image.png', 'Not Allowed Image Example', 'A47', 230)) {
            $sheet->setCellValue('A63', 'Example image (Not Allowed)');
        }

        $this->lockInstructionSheet($sheet);
        $sheet->getColumnDimension('A')->setWidth(80);
    }

    private function applySkuValidation(Worksheet $sheet, array $headers): void
    {
        $col = Coordinate::stringFromColumnIndex(array_search('SKU', $headers, true) + 1);
        for ($row = 2; $row <= 100; $row++) {
            $validation = $sheet->getCell($col . $row)->getDataValidation();
            $validation->setType(DataValidation::TYPE_CUSTOM);
            $validation->setAllowBlank(false);
            $validation->setFormula1('=LEN(' . $col . $row . ')>0');
            $validation->setShowInputMessage(true);
            $validation->setPromptTitle('SKU');
            $validation->setPrompt(
                'Required. Must be unique. If Color/Colour has value, upload images as SKU-front, SKU-back, SKU-top, SKU-side.'
            );
        }
    }

    private function applyStatusValidation(Worksheet $sheet, array $headers): void
    {
        $col = Coordinate::stringFromColumnIndex(array_search('Status', $headers, true) + 1);
        for ($row = 2; $row <= 100; $row++) {
            $validation = $sheet->getCell($col . $row)->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setAllowBlank(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"Active,Inactive"');
            $validation->setShowInputMessage(true);
            $validation->setPromptTitle('Status');
            $validation->setPrompt('Allowed values: Active or Inactive.');
        }
    }

    private function applyPriceValidation(Worksheet $sheet, array $headers): void
    {
        $index = array_search('Price', $headers, true);
        if ($index === false) {
            return;
        }

        $col = Coordinate::stringFromColumnIndex($index + 1);
        for ($row = 2; $row <= 100; $row++) {
            $validation = $sheet->getCell($col . $row)->getDataValidation();
            $validation->setType(DataValidation::TYPE_DECIMAL);
            $validation->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);
            $validation->setFormula1('0');

            $validation->setAllowBlank(true);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);

            $validation->setPromptTitle('Price');
            $validation->setPrompt('Enter numeric value only (example: 499 or 499.99).');

            $validation->setErrorTitle('Invalid Price');
            $validation->setError('Price must be a numeric value.');

        }
    }

    private function applyStockValidation(Worksheet $sheet, array $headers): void
    {
        $index = array_search('Stock', $headers, true);
        if ($index === false) {
            return;
        }

        $col = Coordinate::stringFromColumnIndex($index + 1);
        for ($row = 2; $row <= 100; $row++) {
            $validation = $sheet->getCell($col . $row)->getDataValidation();
            $validation->setType(DataValidation::TYPE_WHOLE);
            $validation->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);
            $validation->setFormula1('0');

            $validation->setAllowBlank(true);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);

            $validation->setPromptTitle('Stock');
            $validation->setPrompt('Enter whole number only (example: 10).');

            $validation->setErrorTitle('Invalid Stock');
            $validation->setError('Stock must be a whole number.');
        }
    }

    private function attachImageIfExists(Worksheet $sheet, string $relativePublicPath, string $name, string $coordinates, int $height): bool
    {
        $fullPath = public_path($relativePublicPath);
        if (!file_exists($fullPath)) {
            return false;
        }

        $drawing = new Drawing();
        $drawing->setName($name);
        $drawing->setDescription($name);
        $drawing->setPath($fullPath);
        $drawing->setHeight($height);
        $drawing->setCoordinates($coordinates);
        $drawing->setWorksheet($sheet);

        return true;
    }

    private function lockInstructionSheet(Worksheet $sheet): void
    {
        $protection = $sheet->getProtection();
        $protection->setPassword('CuddlyDuddlyInstructions');
        $protection->setSheet(true);
        $protection->setObjects(true);
        $protection->setScenarios(true);
        $protection->setFormatCells(true);
        $protection->setFormatColumns(true);
        $protection->setFormatRows(true);
        $protection->setInsertColumns(true);
        $protection->setInsertRows(true);
        $protection->setInsertHyperlinks(true);
        $protection->setDeleteColumns(true);
        $protection->setDeleteRows(true);
        $protection->setSort(true);
        $protection->setAutoFilter(true);
        $protection->setPivotTables(true);
        $protection->setSelectLockedCells(false);
        $protection->setSelectUnlockedCells(false);

        $sheet->getParent()->getSecurity()->setWorkbookPassword('CuddlyDuddlyWorkbook');
        $sheet->getParent()->getSecurity()->setLockStructure(true);
    }

    private function mapUploadedImagesBySkuAndView(array $files): array
    {
        $mapped = [];

        foreach ($this->flattenUploadedFiles($files) as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $name = $file->getClientOriginalName();
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if (!in_array($ext, self::ALLOWED_IMAGE_EXTENSIONS)) {
                continue;
            }

            $base = trim(pathinfo($name, PATHINFO_FILENAME));
            $view = $this->extractSkuViewSuffix($base);
            if ($view === null) {
                continue;
            }

            $skuBase = $this->normalizeSkuForVariant($base);
            if ($skuBase === '') {
                continue;
            }

            $sku = $this->canonicalSkuKey($skuBase);

            $mapped[$sku][$view] = $file;
        }

        return $mapped;
    }

    private function flattenUploadedFiles(array $files): array
    {
        $flattened = [];

        foreach ($files as $item) {
            if (is_array($item)) {
                $flattened = array_merge($flattened, $this->flattenUploadedFiles($item));
                continue;
            }

            $flattened[] = $item;
        }

        return $flattened;
    }

    private function missingViewsForSku(array $imagesBySkuView, string $skuKey): array
    {
        $available = array_keys($imagesBySkuView[$skuKey] ?? []);
        return array_values(array_diff(self::REQUIRED_VIEWS, $available));
    }

    private function storeSkuViewImages(array $imagesByView, string $sku, array &$storedImagePaths): array
    {
        $stored = [];

        foreach (self::REQUIRED_VIEWS as $view) {
            $imageFile = $imagesByView[$view];
            $fileName = Str::slug($sku, '-')
                . '-' . $view
                . '-' . time()
                . '-' . uniqid()
                . '.' . Str::lower($imageFile->getClientOriginalExtension());

            $stored[$view] = $imageFile->storeAs('variant-images', $fileName, 'public');
            $storedImagePaths[] = $stored[$view];
        }

        return $stored;
    }

    private function assertSellerAuthorized(Sellers $seller): void
    {
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }
    }

    private function resolveOwnedProduct(Sellers $seller, int $productId): ?Products
    {
        return Products::where('id', $productId)
            ->where('seller_id', $seller->id)
            ->first();
    }

    private function storeUploadedExcelFile(UploadedFile $file, int $sellerId, int $productId): string
    {
        $disk = Storage::disk('public');
        $directory = "variant-imports/{$sellerId}/{$productId}";
        $existingFiles = $disk->files($directory);
        $previousLatestFiles = array_values(array_filter($existingFiles, function ($path) {
            return Str::startsWith(basename($path), 'latest-variant-sheet.');
        }));

        if (!empty($previousLatestFiles)) {
            $disk->delete($previousLatestFiles);
        }

        $extension = Str::lower($file->getClientOriginalExtension() ?: 'xlsx');
        if (!in_array($extension, ['xlsx', 'xls'], true)) {
            $extension = 'xlsx';
        }

        $fileName = "latest-variant-sheet.{$extension}";
        return $file->storeAs($directory, $fileName, 'public');
    }

    // private function resolveLatestUploadedExcelPath(int $sellerId, int $productId): ?string
    // {
    //     $disk = Storage::disk('public');
    //     $directory = "variant-imports/{$sellerId}/{$productId}";

    //     foreach (['xlsx', 'xls'] as $extension) {
    //         $path = "{$directory}/latest-variant-sheet.{$extension}";
    //         if ($disk->exists($path)) {
    //             return $path;
    //         }
    //     }

    //     return null;
    // }

    // private function uploadedExcelHasVariantRows(string $excelPath): bool
    // {
    //     $fullPath = Storage::disk('public')->path($excelPath);
    //     if (!is_file($fullPath)) {
    //         return false;
    //     }

    //     $spreadsheet = IOFactory::load($fullPath);
    //     $templateSheet = $spreadsheet->getSheetByName(self::TEMPLATE_SHEET) ?? $spreadsheet->getSheet(0);
    //     $rows = $templateSheet->toArray();

    //     if (count($rows) < 2) {
    //         return false;
    //     }

    //     array_shift($rows);

    //     foreach ($rows as $row) {
    //         $hasValue = array_filter($row, function ($value) {
    //             return trim((string) $value) !== '';
    //         });

    //         if (!empty($hasValue)) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }

    private function resolveImageViewName(string $column): string
    {
        return match ($column) {
            'image' => 'front',
            'image1' => 'back',
            'image2' => 'top',
            'image3' => 'side',
            'image4' => 'extra',
            default => $column,
        };
    }

    private function makeUniqueZipEntryName(string $candidateName, array $usedNames): string
    {
        if (!in_array($candidateName, $usedNames, true)) {
            return $candidateName;
        }

        $fileBase = pathinfo($candidateName, PATHINFO_FILENAME);
        $extension = pathinfo($candidateName, PATHINFO_EXTENSION);
        $suffix = 2;

        do {
            $nextName = $fileBase . '-' . $suffix . ($extension ? ".{$extension}" : '');
            $suffix++;
        } while (in_array($nextName, $usedNames, true));

        return $nextName;
    }

    private function normalizeSkuForImageMatching(string $sku): string
    {
        return $this->canonicalSkuKey($sku);
    }

    private function normalizeSkuForVariant(string $sku): string
    {
        $trimmed = trim($sku);
        if ($trimmed === '') {
            return '';
        }

        return $this->stripSkuViewSuffix($trimmed);
    }

    private function extractSkuViewSuffix(string $sku): ?string
    {
        $trimmed = trim($sku);
        if ($trimmed === '') {
            return null;
        }

        if (preg_match('/(?:^|[\s._-])(front|back|top|side)(?:[\s_-]*(?:\(\d+\)|\d+))?$/i', $trimmed, $matches)) {
            return Str::lower($matches[1]);
        }

        return null;
    }

    private function canonicalSkuKey(string $sku): string
    {
        $value = Str::lower($this->stripSkuViewSuffix(trim($sku)));
        $value = preg_replace('/[\s_]+/', '-', $value) ?? $value;
        $value = preg_replace('/[^a-z0-9-]+/', '-', $value) ?? $value;
        $value = preg_replace('/-+/', '-', $value) ?? $value;

        return trim($value, '-');
    }

    private function stripSkuViewSuffix(string $value): string
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            return '';
        }

        $stripped = preg_replace(
            '/(?:^|[\s._-])(front|back|top|side)(?:[\s_-]*(?:\(\d+\)|\d+))?$/i',
            '',
            $trimmed
        ) ?? $trimmed;

        return trim($stripped, " \t\n\r\0\x0B-_.");
    }

    private function resolveImageLookupKey(array $imagesBySkuView, string $sku, string $skuBase): ?string
    {
        $candidates = array_unique(array_filter([
            $this->canonicalSkuKey($sku),
            $this->canonicalSkuKey($skuBase),
            $this->normalizeSkuForImageMatching($sku),
            $this->normalizeSkuForImageMatching($skuBase),
        ]));

        foreach ($candidates as $candidate) {
            if (!empty($imagesBySkuView[$candidate] ?? [])) {
                return $candidate;
            }
        }

        return null;
    }

    private function formatAvailableImageSets(array $imagesBySkuView): string
    {
        if (empty($imagesBySkuView)) {
            return '';
        }

        $parts = [];
        foreach ($imagesBySkuView as $skuKey => $views) {
            $viewList = array_keys((array) $views);
            sort($viewList);
            $parts[] = $skuKey . '(' . implode(',', $viewList) . ')';
        }

        sort($parts);
        return implode('; ', $parts);
    }

    private function hasUploadedVariantImages(int $productId): bool
    {
        $imageColumns = array_values(array_filter(
            ['image', 'image1', 'image2', 'image3', 'image4'],
            fn($column) => $this->hasProductVariantColumn($column)
        ));

        if (empty($imageColumns)) {
            return false;
        }

        $variants = ProductVariant::where('product_id', $productId)->get($imageColumns);
        foreach ($variants as $variant) {
            foreach ($imageColumns as $column) {
                $path = trim((string) ($variant->{$column} ?? ''));
                if ($path !== '' && Storage::disk('public')->exists($path)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function productHasVariants(int $productId): bool
    {
        return ProductVariant::where('product_id', $productId)->exists();
    }

    private function buildVariantExportHeaders($variants): array
    {
        $attributeHeaders = [];

        foreach ($variants as $variant) {
            foreach ($variant->attributeValues as $attributeValue) {
                $attributeName = trim((string) ($attributeValue->attribute->name ?? ''));
                if ($attributeName === '') {
                    continue;
                }

                $attributeHeaders[$attributeName] = true;
            }
        }

        return array_merge(array_keys($attributeHeaders), self::FIXED_COLUMNS);
    }

    private function mapVariantForExportRow(ProductVariant $variant, array $headers): array
    {
        $row = array_fill_keys($headers, '');

        foreach ($variant->attributeValues as $attributeValue) {
            $attributeName = trim((string) ($attributeValue->attribute->name ?? ''));
            if ($attributeName === '' || !array_key_exists($attributeName, $row)) {
                continue;
            }

            $row[$attributeName] = $attributeValue->value;
        }

        $row['SKU'] = $variant->sku;
        $row['Price'] = $variant->price;
        $row['Stock'] = $variant->stock;
        $row['Status'] = $variant->is_active ? 'Active' : 'Inactive';

        return $row;
    }

    private function resolveVariantImageColumn(): string
    {
        if ($this->hasProductVariantColumn('image')) {
            return 'image';
        }

        if ($this->hasProductVariantColumn('image1')) {
            return 'image1';
        }

        throw new \Exception('No variant image column found. Add `image` or `image1` column in product_variants table.');
    }

    private function resolveVariantImageColumnsForViews(array $requiredViews): array
    {
        $columns = [];
        $usedColumns = [];
        $viewCandidates = [
            'front' => ['image', 'image1'],
            'back' => ['image1', 'image2'],
            'top' => ['image2', 'image3'],
            'side' => ['image3', 'image4'],
        ];

        foreach ($requiredViews as $view) {
            if (!isset($viewCandidates[$view])) {
                throw new \Exception("Unsupported image view: {$view}");
            }

            $column = null;
            foreach ($viewCandidates[$view] as $candidateColumn) {
                if (
                    $this->hasProductVariantColumn($candidateColumn)
                    && !in_array($candidateColumn, $usedColumns, true)
                ) {
                    $column = $candidateColumn;
                    break;
                }
            }

            if ($column === null) {
                throw new \Exception(
                    "Missing database column for {$view} image. Expected one of: "
                    . implode(', ', $viewCandidates[$view]) . '.'
                );
            }

            $columns[$view] = $column;
            $usedColumns[] = $column;
        }

        return $columns;
    }

    private function extractValue(array $data, array $possibleKeys): ?string
    {
        foreach ($possibleKeys as $key) {
            if (!array_key_exists($key, $data)) {
                continue;
            }

            $value = trim((string) $data[$key]);
            if ($value !== '') {
                return $value;
            }
        }

        return null;
    }

    private function hasProductVariantColumn(string $column): bool
    {
        return in_array(Str::lower($column), $this->getProductVariantColumns(), true);
    }

    private function getProductVariantColumns(): array
    {
        static $columns = null;
        if ($columns !== null) {
            return $columns;
        }

        $result = DB::select('SHOW COLUMNS FROM `product_variants`');
        $columns = [];

        foreach ($result as $row) {
            $name = isset($row->Field) ? (string) $row->Field : '';
            if ($name !== '') {
                $columns[] = Str::lower($name);
            }
        }

        return $columns;
    }

    private function extractPrice(array $data): float
    {
        $value = $this->extractValue($data, ['Price', 'MRP', 'Mrp', 'price', 'mrp']);
        return is_numeric($value) ? (float) $value : 0.0;
    }

    private function extractStock(array $data): int
    {
        $value = $this->extractValue($data, ['Stock', 'stock']);
        return is_numeric($value) ? (int) $value : 0;
    }

    private function extractStatus(array $data): bool
    {
        $value = Str::lower((string) ($this->extractValue($data, ['Status', 'status']) ?? 'active'));
        return in_array($value, ['active', '1', 'true', 'yes'], true);
    }

    private function extractColorValue(array $data): ?string
    {
        foreach ($data as $key => $rawValue) {
            $normalizedKey = Str::lower((string) $key);
            $normalizedKey = str_replace([' ', '_', '-'], '', $normalizedKey);

            if (!in_array($normalizedKey, ['color', 'colour'], true)) {
                continue;
            }

            $value = trim((string) $rawValue);
            if ($value !== '') {
                return $value;
            }
        }

        return null;
    }

    private function extractSkuValue(array $data): ?string
    {
        foreach ($data as $key => $rawValue) {
            $normalizedKey = Str::lower((string) $key);
            $normalizedKey = str_replace([' ', '_', '-'], '', $normalizedKey);

            if ($normalizedKey !== 'sku') {
                continue;
            }

            $value = trim((string) $rawValue);
            if ($value !== '') {
                return $value;
            }
        }

        return null;
    }

    private function extractPrefillSkusFromRequest(Request $request): array
    {
        $rawSkus = $request->query('sku_names', []);
        if (is_string($rawSkus)) {
            $rawSkus = [$rawSkus];
        }

        if (is_array($rawSkus) && !empty($rawSkus)) {
            $skus = [];
            foreach ($rawSkus as $rawSku) {
                $sku = Str::upper(trim((string) $rawSku));
                if ($sku === '') {
                    continue;
                }

                $key = Str::lower($sku);
                if (!isset($skus[$key])) {
                    $skus[$key] = $sku;
                }
            }

            return array_values($skus);
        }

        $rawNames = $request->query('image_names', []);
        if (is_string($rawNames)) {
            $rawNames = [$rawNames];
        }

        if (!is_array($rawNames)) {
            return [];
        }

        $skus = [];
        foreach ($rawNames as $rawName) {
            $name = trim((string) $rawName);
            if ($name === '') {
                continue;
            }

            $baseName = trim(pathinfo($name, PATHINFO_FILENAME));
            if ($baseName === '') {
                continue;
            }

            // Remove extension only and force uppercase SKU.
            $sku = Str::upper($baseName);
            $key = Str::lower(trim($sku));
            if ($key === '') {
                continue;
            }

            if (!isset($skus[$key])) {
                $skus[$key] = trim($sku);
            }
        }

        return array_values($skus);
    }

    private function prefillSkuColumnFromImageNames(Worksheet $sheet, array $headers, array $skus): void
    {
        if (empty($skus)) {
            return;
        }

        $index = array_search('SKU', $headers, true);
        if ($index === false) {
            return;
        }

        $col = Coordinate::stringFromColumnIndex($index + 1);
        $row = 2;

        foreach ($skus as $sku) {
            if ($row > 100) {
                break;
            }

            $safeSku = preg_match('/^[=+\-@]/', $sku) ? "'" . $sku : $sku;
            $sheet->setCellValue($col . $row, $safeSku);
            $row++;
        }
    }
}