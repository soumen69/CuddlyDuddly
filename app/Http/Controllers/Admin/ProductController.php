<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Sellers;
use App\Models\Brands;
use App\Models\MasterCategorySection;
use App\Models\ProductImage;
use App\Models\ProductCategorySection;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductCategoryAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariant;
use App\Models\VariantAttributeValue;
use App\Models\ProductAttributeValueImage;
use App\Services\ProductCodeService;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    private function uploadedNestedFiles(Request $request, array $keys): array
    {
        $allFiles = $request->allFiles();

        foreach ($keys as $key) {
            $files = data_get($allFiles, $key);
            if (!empty($files)) {
                return is_array($files) ? $files : [];
            }
        }

        return [];
    }

    private function normalizeVariantSkus(Request $request): void
    {
        $variants = $request->input('variants');
        if (!is_array($variants)) {
            return;
        }

        foreach ($variants as $i => $variant) {
            if (!is_array($variant) || !array_key_exists('sku', $variant)) {
                continue;
            }

            $sku = $variant['sku'];
            $sku = is_string($sku) ? trim($sku) : $sku;

            if ($sku === '') {
                $sku = null;
            }

            $variant['sku'] = $sku;
            $variants[$i] = $variant;
        }

        $request->merge(['variants' => $variants]);
    }

    private function assertUniqueVariantSkusForCreate(array $variants): void
    {
        $skus = [];

        foreach ($variants as $variantData) {
            if (!is_array($variantData)) {
                continue;
            }

            $enabled = filter_var($variantData['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
            if (!$enabled) {
                continue;
            }

            $sku = $variantData['sku'] ?? null;
            $sku = is_string($sku) ? trim($sku) : $sku;

            if ($sku === null || $sku === '') {
                continue;
            }

            $skus[] = $sku;
        }

        if (empty($skus)) {
            return;
        }

        $uniqueSkus = array_values(array_unique($skus));
        if (count($uniqueSkus) !== count($skus)) {
            throw ValidationException::withMessages([
                'variants' => ['Duplicate SKU found in variants. Please make each variant SKU unique (or leave it blank).']
            ]);
        }

        $existing = ProductVariant::whereIn('sku', $uniqueSkus)->pluck('sku')->unique()->values()->all();

        if (!empty($existing)) {
            throw ValidationException::withMessages([
                'variants' => ['SKU already exists: ' . implode(', ', $existing)]
            ]);
        }
    }

    private function assertUniqueVariantSkusForUpdate(array $variants, array $existingMap): void
    {
        $seenSkus = [];

        foreach ($variants as $variantData) {
            if (!is_array($variantData)) {
                continue;
            }

            $enabled = filter_var($variantData['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
            if (!$enabled) {
                continue;
            }

            $sku = $variantData['sku'] ?? null;
            $sku = is_string($sku) ? trim($sku) : $sku;

            if ($sku === null || $sku === '') {
                continue;
            }

            $key = collect($variantData['values'] ?? [])
                ->map(fn($v) => (int) $v)->sort()->implode('-');

            $currentVariantId = isset($existingMap[$key]) ? $existingMap[$key]->id : null;

            if (isset($seenSkus[$sku]) && $seenSkus[$sku] !== $currentVariantId) {
                throw ValidationException::withMessages([
                    'variants' => ['Duplicate SKU found in variants. Please make each variant SKU unique (or leave it blank).']
                ]);
            }

            $conflictQuery = ProductVariant::where('sku', $sku);
            if ($currentVariantId) {
                $conflictQuery->where('id', '!=', $currentVariantId);
            }

            if ($conflictQuery->exists()) {
                throw ValidationException::withMessages([
                    'variants' => ['SKU already exists: ' . $sku]
                ]);
            }

            $seenSkus[$sku] = $currentVariantId;
        }
    }

    // public function index(Request $request)
    // {
    //     $sellers = Sellers::select('id', 'name', 'contact_person')->get();

    //     $query = Products::query()
    //         ->with([
    //             'seller:id,name',
    //             'approvedBy:id,name',
    //             'primaryImage:id,product_id,image_path',
    //             'primaryVariantImage:id,product_id,image_path'
    //         ])

    //         // ✅ VARIANT AGGREGATES
    //         ->withCount([
    //             'variants as active_variants_count' => fn($q) => $q->where('status', 1)
    //         ])
    //         ->withMin([
    //             'variants as min_variant_price' => fn($q) => $q->where('status', 1)
    //         ], 'price')
    //         ->withMax([
    //             'variants as max_variant_price' => fn($q) => $q->where('status', 1)
    //         ], 'price')
    //         ->withSum([
    //             'variants as total_variant_stock' => fn($q) => $q->where('status', 1)
    //         ], 'stock')
    //         ->withExists([
    //             'visualImages as has_visual_variants'
    //         ]);

    //     // 🔍 SEARCH
    //     if ($request->filled('search')) {
    //         $search = trim($request->search);
    //         $query->where(
    //             fn($q) =>
    //             $q->where('name', 'like', "%$search%")
    //                 ->orWhere('description', 'like', "%$search%")
    //         );
    //     }

    //     // APPROVAL
    //     if ($request->filled('approval_status')) {
    //         $query->where('is_approved', $request->approval_status === 'approved');
    //     }

    //     // FEATURED
    //     if ($request->filled('featured')) {
    //         $query->where('featured', $request->featured);
    //     }

    //     // SELLER
    //     if ($request->filled('seller_id')) {
    //         $query->where('seller_id', $request->seller_id);
    //     }

    //     // STATUS
    //     if ($request->filled('status')) {
    //         $query->where('status', $request->status);
    //     }

    //     // SORTING
    //     switch ($request->get('sort')) {

    //         case 'oldest':
    //             $query->oldest();
    //             break;

    //         case 'price_low_high':
    //             $query->orderByRaw('COALESCE(min_variant_price, price) ASC');
    //             break;

    //         case 'price_high_low':
    //             $query->orderByRaw('COALESCE(max_variant_price, price) DESC');
    //             break;

    //         case 'stock_low_high':
    //             $query->orderByRaw('COALESCE(total_variant_stock, stock) ASC');
    //             break;

    //         case 'stock_high_low':
    //             $query->orderByRaw('COALESCE(total_variant_stock, stock) DESC');
    //             break;

    //         case 'name':
    //             $query->orderBy('name');
    //             break;

    //         default:
    //             $query->latest();
    //     }

    //     $products = $query->paginate(5)->withQueryString();

    //     return view('admin.products.index', compact('products', 'sellers'));
    // }

    public function index(Request $request)
    {
        $sellers = Sellers::select('id', 'name', 'contact_person')->get();
        $categories = ProductCategory::select('id', 'name', 'slug')->get();
        $brands = Brands::select('id', 'name')->get();
        $query = Products::query()
            ->with([
                'seller:id,name',
                'approvedBy:id,name',
                'primaryImage:id,product_id,image_path',
            ])

            // ✅ VARIANT AGGREGATES
            ->withCount([
                'variants as active_variants_count' => fn($q) => $q->where('status', 1)
            ])
            ->withMin([
                'variants as min_variant_price' => fn($q) => $q->where('status', 1)
            ], 'price')
            ->withMax([
                'variants as max_variant_price' => fn($q) => $q->where('status', 1)
            ], 'price')
            ->withSum([
                'variants as total_variant_stock' => fn($q) => $q->where('status', 1)
            ], 'stock')
            ->withExists([
                'visualImages as has_visual_variants'
            ]);

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(
                fn($q) =>
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
            );
        }

        // APPROVAL
        if ($request->filled('approval_status')) {
            $query->where('is_approved', $request->approval_status === 'approved');
        }

        // FEATURED
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured);
        }

        // SELLER
        if ($request->filled('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }

        // STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // SORTING
        switch ($request->get('sort')) {

            case 'oldest':
                $query->oldest();
                break;

            case 'price_low_high':
                $query->orderByRaw('COALESCE(min_variant_price, price) ASC');
                break;

            case 'price_high_low':
                $query->orderByRaw('COALESCE(max_variant_price, price) DESC');
                break;

            case 'stock_low_high':
                $query->orderByRaw('COALESCE(total_variant_stock, stock) ASC');
                break;

            case 'stock_high_low':
                $query->orderByRaw('COALESCE(total_variant_stock, stock) DESC');
                break;

            case 'name':
                $query->orderBy('name');
                break;

            default:
                $query->latest();
        }

        $products = $query->paginate(5)->withQueryString();

        return view('admin.products.index', compact('products', 'sellers', 'categories', 'brands'));
    }

    public function bulkSubcategories(Request $request)
    {
        return ProductSubCategory::whereIn(
            'product_categories_id',
            $request->categories
        )->select('id', 'name')->get();
    }

    public function create()
    {
        $sellers = Sellers::select('id', 'name')->get();

        // Navigation chain
        $categoryTree = MasterCategorySection::with([
            'masterCategory',
            'sectionType',
            'category'
        ])->get();

        // Classified categories
        $productCategories = ProductCategory::with([
            'subCategories' => function ($q) {
                $q->where('status', 1);
            }
        ])
            ->where('status', 1)
            ->get();

        return view('admin.products.create', compact(
            'sellers',
            'categoryTree',
            'productCategories'
        ));
    }

    public function getCategoryAttributes(ProductCategory $category)
    {
        if (!auth('admin')->check() && !auth('seller')->check()) {
            abort(403);
        }
        $attributes = ProductCategoryAttribute::with([
            'attribute.values'
        ])
            ->where('product_categories_id', $category->id)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {

                $attr = $item->attribute;

                return [
                    'id' => $attr->id,
                    'name' => $attr->name,
                    'is_variant' => (bool) $attr->is_variant,
                    'is_visual' => (bool) $attr->is_visual,
                    'values' => $attr->values->map(function ($val) {
                        return [
                            'id' => $val->id,
                            'value' => $val->value
                        ];
                    })
                ];
            });

        return response()->json($attributes);
    }

    public function store(Request $request)
    {
        $this->normalizeVariantSkus($request);

        $validated = $request->validate([

            'seller_id' => ['required', 'exists:sellers,id'],

            'product_categories_id' => ['required', 'exists:product_categories,id'],
            'product_sub_categories_id' => ['required', 'exists:product_sub_categories,id'],

            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'price' => ['required', 'numeric', 'min:99'],
            'stock' => ['nullable', 'integer', 'min:0'],

            'master_category_section_id' => ['required', 'array', 'min:1'],
            'master_category_section_id.*' => ['exists:master_category_sections,id'],

            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['array'],
            'attributes.*.*' => ['exists:attribute_values,id'],

            'variants' => ['nullable', 'array'],
            'variants.*.enabled' => ['nullable', 'boolean'],
            'variants.*.sku' => ['nullable', 'string', 'max:100'],
            'variants.*.price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'variants.*.values' => ['required_with:variants', 'array'],
            'variants.*.values.*' => ['exists:attribute_values,id'],

            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png', 'max:500'],
            'visual_images' => ['nullable', 'array'],
            'visual_images.*' => ['array'],
            'visual_images.*.*' => ['image', 'mimes:jpeg,jpg,png', 'max:500'],
            'visual_images_new' => ['nullable', 'array'],
            'visual_images_new.*' => ['array'],
            'visual_images_new.*.*' => ['image', 'mimes:jpeg,jpg,png', 'max:500'],
        ]);

        $this->assertUniqueVariantSkusForCreate($validated['variants'] ?? []);
        $visualImageFiles = $this->uploadedNestedFiles($request, ['visual_images', 'visual_images_new']);
        $hasVisualImages = !empty($visualImageFiles);
        if ($hasVisualImages) {
            foreach ($visualImageFiles as $valueId => $files) {
                if (count($files) < 3) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Each visual variant must have at least 3 images.'
                        ], 422);
                    }

                    return back()->withInput()->withErrors([
                        'visual_images' => 'Each visual variant must have at least 3 images.'
                    ]);
                }
            }
        } else {
            if (!$request->hasFile('images') || count($request->file('images')) < 3) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'At least 3 product images are required.'
                    ], 422);
                }

                return back()->withInput()->withErrors([
                    'images' => 'At least 3 product images are required.'
                ]);
            }
        }

        DB::beginTransaction();

        try {

            $product = Products::create([
                'product_code' => ProductCodeService::generate($validated['product_categories_id']),
                'seller_id' => $validated['seller_id'],
                'product_categories_id' => $validated['product_categories_id'],
                'product_sub_categories_id' => $validated['product_sub_categories_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
                'price' => $validated['price'],
                'stock' => $validated['stock'] ?? 0,
                'featured' => 0,
                'is_approved' => 0,
                'status' => 1,
            ]);

            // ATTRIBUTES
            if (!empty($validated['attributes'])) {
                $rows = [];
                foreach ($validated['attributes'] as $values) {
                    foreach (array_unique($values) as $valueId) {
                        $rows[] = [
                            'product_id' => $product->id,
                            'attribute_value_id' => $valueId
                        ];
                    }
                }
                ProductAttributeValue::insert($rows);
            }


            // VARIANTS
            if (!empty($validated['variants'])) {

                foreach ($validated['variants'] as $variantData) {

                    $enabled = filter_var($variantData['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);

                    if (!$enabled) {
                        continue; // ignore disabled variant completely
                    }

                    $sku = $variantData['sku'] ?? null;
                    $sku = is_string($sku) ? trim($sku) : $sku;
                    if ($sku === '') {
                        $sku = null;
                    }

                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $sku,
                        'price' => $variantData['price'] ?? $product->price,
                        'stock' => $variantData['stock'] ?? 0,
                        'status' => 1,
                    ]);

                    $rows = [];

                    $uniqueValues = array_unique($variantData['values'] ?? []);

                    foreach ($uniqueValues as $valueId) {
                        $rows[] = [
                            'variant_id' => $variant->id,
                            'attribute_value_id' => $valueId
                        ];
                    }

                    if (!empty($rows)) {
                        VariantAttributeValue::insert($rows);
                    }
                }
            }

            if (!$hasVisualImages) {
                $isPrimary = true;
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products/' . date('Y/m'), 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $isPrimary ? 1 : 0
                    ]);
                    $isPrimary = false;
                }
            }


            // VISUAL ATTRIBUTE IMAGES
            if (!empty($validated['visual_images'])) {
                foreach ($request->file('visual_images') as $attributeValueId => $images) {
                    $isPrimary = true;
                    $sortOrder = 0;
                    foreach ($images as $image) {
                        $path = $image->store('products/variants/' . date('Y/m'), 'public');
                        ProductAttributeValueImage::create([
                            'product_id' => $product->id,
                            'attribute_value_id' => $attributeValueId,
                            'image_path' => $path,
                            'is_primary' => $isPrimary ? 1 : 0,
                            'sort_order' => $sortOrder++
                        ]);
                        $isPrimary = false;
                    }
                }
            }

            // CATEGORY PLACEMENT
            $rows = [];

            foreach ($validated['master_category_section_id'] as $sectionId) {

                $rows[] = [
                    'product_id' => $product->id,
                    'master_category_section_id' => $sectionId
                ];
            }

            ProductCategorySection::insert($rows);


            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('admin.products.index'),
                    'message' => 'Product added successfully'
                ]);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product added successfully');
        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while saving the product.'
                ], 500);
            }

            return back()
                ->withInput()
                ->withErrors([
                    'system' => 'Something went wrong while saving the product.'
                ]);
        }
    }

    public function destroy(Request $request)
    {
        $ids = is_array($request->ids)
            ? $request->ids
            : json_decode($request->ids, true);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No products selected for deletion.']);
        }

        DB::beginTransaction();

        try {
            $products = Products::with('images')->whereIn('id', $ids)->get();

            foreach ($products as $product) {
                // 🖼️ Delete images from storage
                foreach ($product->images as $image) {
                    if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                }

                // 🔗 Delete related category mappings
                ProductCategorySection::where('product_id', $product->id)->delete();

                // 🧾 Finally delete product
                $product->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Selected products deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error deleting products: ' . $e->getMessage(),
            ]);
        }
    }

    public function bulkFeature(Request $request)
    {
        $products = Products::whereIn('id', $request->ids)->get();
        foreach ($products as $product) {
            $product->featured = !$product->featured;
            $product->save();
        }
        return response()->json(['success' => true, 'message' => 'Feature status toggled successfully.']);
    }

    public function bulkApprove(Request $request)
    {
        $products = Products::whereIn('id', $request->ids)->get();
        foreach ($products as $product) {
            $product->is_approved = !$product->is_approved;
            $product->save();
        }
        return response()->json(['success' => true, 'message' => 'Approval status toggled successfully.']);
    }

    public function edit($id)
    {
        $product = Products::with([
            'images',
            'variants.values',
            'attributeValues.attributeValue',
            'categorySections',
            'visualImages.attributeValue'
        ])->findOrFail($id);

        $sellers = Sellers::select('id', 'name')->get();

        $categoryTree = MasterCategorySection::with([
            'masterCategory',
            'sectionType',
            'category'
        ])->get();

        $productCategories = ProductCategory::with([
            'subCategories' => function ($q) {
                $q->where('status', 1);
            }
        ])
            ->where('status', 1)
            ->get();

        return view('admin.products.edit', compact(
            'product',
            'sellers',
            'categoryTree',
            'productCategories'
        ));
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $this->normalizeVariantSkus($request);

        $validated = $request->validate([
            'seller_id' => ['required', 'exists:sellers,id'],
            'product_categories_id' => ['required', 'exists:product_categories,id'],
            'product_sub_categories_id' => ['required', 'exists:product_sub_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:99'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'master_category_section_id' => ['required', 'array', 'min:1'],
            'master_category_section_id.*' => ['exists:master_category_sections,id'],

            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['array'],
            'attributes.*.*' => ['exists:attribute_values,id'],

            'variants' => ['sometimes', 'array'],
            'variants.*.enabled' => ['nullable', 'boolean'],
            'variants.*.id' => ['nullable', 'exists:product_variants,id'],
            'variants.*.sku' => ['nullable', 'string', 'max:100'],
            'variants.*.price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'variants.*.values' => ['required', 'array'],
            'variants.*.values.*' => ['exists:attribute_values,id'],

            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png', 'max:500'],

            'visual_images_new' => ['nullable', 'array'],
            'visual_images_new.*' => ['array'],
            'visual_images_new.*.*' => ['image', 'mimes:jpeg,jpg,png', 'max:500'],
            'visual_images' => ['nullable', 'array'],
            'visual_images.*' => ['array'],
            'visual_images.*.*' => ['image', 'mimes:jpeg,jpg,png', 'max:500'],
            'visual_images_removed' => ['nullable', 'string'],
        ]);

        $existingVariantsForSkuCheck = ProductVariant::with('values')
            ->where('product_id', $product->id)->get();

        $existingMapForSkuCheck = [];
        foreach ($existingVariantsForSkuCheck as $variant) {
            $key = $variant->values->pluck('id')->sort()->implode('-');
            $existingMapForSkuCheck[$key] = $variant;
        }

        $this->assertUniqueVariantSkusForUpdate($validated['variants'] ?? [], $existingMapForSkuCheck);

        $hasExistingVisualImages = $product->visualImages()->exists();
        $visualImageFiles = $this->uploadedNestedFiles($request, ['visual_images_new', 'visual_images']);
        $hasNewVisualImages = !empty($visualImageFiles);
        $hasAnyVisualImages = $hasExistingVisualImages || $hasNewVisualImages;

        if ($hasAnyVisualImages) {

            $removedIds = json_decode($request->visual_images_removed ?? '[]', true);

            // ✅ get ALL attribute value ids (existing + new)
            $allValueIds = collect($product->visualImages()->pluck('attribute_value_id'))
                ->merge(array_keys($visualImageFiles))
                ->unique();

            foreach ($allValueIds as $valueId) {

                $existingCount = $product->visualImages()
                    ->where('attribute_value_id', $valueId)
                    ->count();

                $removedCount = 0;
                if (!empty($removedIds)) {
                    $removedCount = $product->visualImages()
                        ->where('attribute_value_id', $valueId)
                        ->whereIn('id', $removedIds)
                        ->count();
                }

                $newCount = isset($visualImageFiles[$valueId])
                    ? count($visualImageFiles[$valueId])
                    : 0;

                $total = ($existingCount - $removedCount) + $newCount;

                if ($total < 3) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Each visual variant must have at least 3 images.'
                    ], 422);
                }
            }
        } else {

            // 🔥 EXISTING IMAGES COUNT
            $existingCount = $product->images()->count();

            // 🔥 REMOVED IMAGES COUNT
            $removedIds = [];
            if ($request->filled('removed_images')) {
                $removedIds = array_filter(explode(',', $request->removed_images));
            }

            $removedCount = count($removedIds);

            // 🔥 NEW IMAGES COUNT
            $newCount = $request->hasFile('images')
                ? count($request->file('images'))
                : 0;

            // 🔥 FINAL COUNT
            $total = ($existingCount - $removedCount) + $newCount;

            if ($total < 3) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'At least 3 product images are required.'
                    ], 422);
                }

                return back()->withInput()->withErrors([
                    'images' => 'At least 3 product images are required.'
                ]);
            }
        }

        // else {
        //     if (!$request->hasFile('images') || count($request->file('images')) < 3) {
        //         if ($request->expectsJson()) {
        //             return response()->json([
        //                 'success' => false,
        //                 'message' => 'At least 3 product images are required.'
        //             ], 422);
        //         }

        //         return back()->withInput()->withErrors([
        //             'images' => 'At least 3 product images are required.'
        //         ]);
        //     }
        // }

        DB::beginTransaction();

        try {

            // ---------------- UPDATE PRODUCT ----------------
            $product->update([
                'seller_id' => $validated['seller_id'],
                'product_categories_id' => $validated['product_categories_id'],
                'product_sub_categories_id' => $validated['product_sub_categories_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'stock' => $validated['stock'] ?? 0,
            ]);

            // ---------------- NORMAL IMAGE REMOVE ----------------
            if ($request->filled('removed_images')) {
                $ids = array_filter(explode(',', $request->removed_images));
                $images = ProductImage::where('product_id', $product->id)
                    ->whereIn('id', $ids)->get();

                foreach ($images as $img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }

            // ---------------- NORMAL IMAGE INSERT ----------------
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products/' . date('Y/m'), 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => 0
                    ]);
                }
            }

            // ensure primary
            $images = ProductImage::where('product_id', $product->id)->orderBy('id')->get();
            if ($images->count() > 0) {
                ProductImage::where('product_id', $product->id)->update(['is_primary' => 0]);
                ProductImage::where('id', $images->first()->id)->update(['is_primary' => 1]);
            }

            // ---------------- CATEGORY SECTION ----------------
            ProductCategorySection::where('product_id', $product->id)->delete();
            $rows = [];
            foreach ($validated['master_category_section_id'] as $sectionId) {
                $rows[] = [
                    'product_id' => $product->id,
                    'master_category_section_id' => $sectionId
                ];
            }
            ProductCategorySection::insert($rows);

            // =========================
            // ✅ ATTRIBUTE VALUES (MOVED HERE)
            // =========================
            ProductAttributeValue::where('product_id', $product->id)->delete();

            if (!empty($validated['attributes'])) {
                $rows = [];
                foreach ($validated['attributes'] as $values) {
                    foreach (array_unique($values) as $valueId) {
                        $rows[] = [
                            'product_id' => $product->id,
                            'attribute_value_id' => $valueId
                        ];
                    }
                }
                ProductAttributeValue::insert($rows);
            }

            // ---------------- VISUAL IMAGE REMOVE ----------------
            if ($request->filled('visual_images_removed')) {
                $ids = json_decode($request->visual_images_removed, true);
                if (!empty($ids)) {
                    $images = ProductAttributeValueImage::where('product_id', $product->id)
                        ->whereIn('id', $ids)->get();

                    foreach ($images as $img) {
                        if (Storage::disk('public')->exists($img->image_path)) {
                            Storage::disk('public')->delete($img->image_path);
                        }
                        $img->delete();
                    }
                }
            }

            // ---------------- VISUAL IMAGE INSERT ----------------
            if (!empty($visualImageFiles)) {
                foreach ($visualImageFiles as $valueId => $images) {
                    $sortOrder = ProductAttributeValueImage::where('product_id', $product->id)
                        ->where('attribute_value_id', $valueId)
                        ->max('sort_order') ?? 0;

                    foreach ($images as $image) {
                        $path = $image->store('products/variants/' . date('Y/m'), 'public');

                        ProductAttributeValueImage::create([
                            'product_id' => $product->id,
                            'attribute_value_id' => $valueId,
                            'image_path' => $path,
                            'is_primary' => 0,
                            'sort_order' => ++$sortOrder
                        ]);
                    }
                }
            }

            // ensure primary per attribute value
            $grouped = ProductAttributeValueImage::where('product_id', $product->id)
                ->get()->groupBy('attribute_value_id');

            foreach ($grouped as $valueId => $images) {
                if (!$images->where('is_primary', 1)->count()) {
                    ProductAttributeValueImage::where('id', $images->first()->id)
                        ->update(['is_primary' => 1]);
                }
            }

            // ---------------- VARIANTS ----------------
            $existingVariants = ProductVariant::with('values')
                ->where('product_id', $product->id)->get();

            $existingMap = [];
            foreach ($existingVariants as $variant) {
                $key = $variant->values->pluck('id')->sort()->implode('-');
                $existingMap[$key] = $variant;
            }

            foreach ($validated['variants'] ?? [] as $variantData) {

                $key = collect($variantData['values'])
                    ->map(fn($v) => (int) $v)->sort()->implode('-');

                $enabled = isset($variantData['enabled']) && $variantData['enabled'] == 1;

                if (!$enabled) {
                    if (isset($existingMap[$key])) {
                        $variant = $existingMap[$key];
                        VariantAttributeValue::where('variant_id', $variant->id)->delete();
                        $variant->delete();
                    }
                    continue;
                }

                $sku = $variantData['sku'] ?? null;
                $sku = is_string($sku) ? trim($sku) : $sku;
                if ($sku === '') {
                    $sku = null;
                }

                if (isset($existingMap[$key])) {
                    $variant = $existingMap[$key];
                    $variant->update([
                        'sku' => $sku,
                        'price' => $variantData['price'] ?? $product->price,
                        'stock' => $variantData['stock'] ?? 0,
                    ]);
                    continue;
                }

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $sku,
                    'price' => $variantData['price'] ?? $product->price,
                    'stock' => $variantData['stock'] ?? 0,
                    'status' => 1
                ]);

                $rows = [];
                foreach ($variantData['values'] as $valueId) {
                    $rows[] = [
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $valueId
                    ];
                }
                VariantAttributeValue::insert($rows);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('admin.products.index'),
                    'message' => 'Product updated successfully'
                ]);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'system' => 'Something went wrong while updating the product.'
                ]);
        }
    }

    public function show($id)
    {
        $product = Products::with([
            'seller:id,name',

            'images' => fn($q) =>
            $q->select('id', 'product_id', 'image_path', 'is_primary')
                ->orderByDesc('is_primary'),

            'visualAttributeImages:id,product_id,attribute_value_id,image_path',

            'variants' => fn($q) =>
            $q->where('status', 1)
                ->with([
                    'values:id,attribute_id,value',
                    'values.attribute:id,name,is_visual'
                ])
        ])
            ->withCount([
                'variants as active_variants_count' => fn($q) => $q->where('status', 1)
            ])
            ->withMin([
                'variants as min_variant_price' => fn($q) => $q->where('status', 1)
            ], 'price')
            ->withMax([
                'variants as max_variant_price' => fn($q) => $q->where('status', 1)
            ], 'price')
            ->withSum([
                'variants as total_variant_stock' => fn($q) => $q->where('status', 1)
            ], 'stock')
            ->findOrFail($id);

        $baseImages = $product->images
            ->pluck('image_path')
            ->map(fn($p) => ltrim($p, '/'))
            ->values();

        $visualPayload = [];

        foreach ($product->visualAttributeImages as $img) {
            $visualPayload[$img->attribute_value_id][] = ltrim($img->image_path, '/');
        }

        $variantPayload = [];
        $variantGraph = [];
        $valueToVariants = [];

        foreach ($product->variants as $variant) {

            $valueIds = $variant->values
                ->pluck('id')
                ->sort()
                ->values()
                ->toArray();

            $key = implode('-', $valueIds);

            $variantPayload[$key] = [
                'id' => $variant->id,
                'price' => $variant->price,
                'stock' => $variant->stock,
                'values' => $valueIds,
            ];

            $variantGraph[$variant->id] = $valueIds;

            foreach ($valueIds as $vid) {
                $valueToVariants[$vid][] = $variant->id;
            }
        }

        $attributeGroups = [];

        foreach ($product->variants as $variant) {
            foreach ($variant->values as $val) {

                $attr = $val->attribute;

                $attributeGroups[$attr->id]['name'] = $attr->name;
                $attributeGroups[$attr->id]['is_visual'] = $attr->is_visual;
                $attributeGroups[$attr->id]['values'][$val->id] = $val->value;
            }
        }
        $initialStock = $product->active_variants_count
            ? $product->total_variant_stock
            : $product->stock;

        return view('admin.products.show', compact(
            'product',
            'baseImages',
            'visualPayload',
            'variantPayload',
            'variantGraph',
            'valueToVariants',
            'attributeGroups',
            'initialStock'
        ));
    }

    public function quickView($id)
    {
        $product = Products::with([
            'seller:id,name',
            'images:id,product_id,image_path,is_primary',
            'visualImages:id,product_id,attribute_value_id,image_path',

            'variants' => fn($q) =>
            $q->where('status', 1)
                ->with('values.attribute'),

        ])
            ->withCount([
                'variants as active_variants_count' => fn($q) => $q->where('status', 1)
            ])
            ->withMin([
                'variants as min_variant_price' => fn($q) => $q->where('status', 1)
            ], 'price')
            ->withMax([
                'variants as max_variant_price' => fn($q) => $q->where('status', 1)
            ], 'price')
            ->withSum([
                'variants as total_variant_stock' => fn($q) => $q->where('status', 1)
            ], 'stock')
            ->withExists([
                'visualImages as has_visual_variants'
            ])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'html' => view('admin.partials.quick-view-card', compact('product'))->render()
        ]);
    }
}
