<?php

namespace App\Http\Controllers\Seller;

use App\Models\Sellers;
use App\Models\Products;
use App\Models\Brands;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\SellerBankDetail;
use App\Models\ProductVariant;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductCodeService;
use App\Models\ProductAttributeValue;
use App\Models\MasterCategorySection;
use App\Models\VariantAttributeValue;
use App\Models\ProductCategorySection;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductAttributeValueImage;
use Illuminate\Validation\ValidationException;
use App\Services\NotificationRecipientResolver;
use App\Services\NotificationTemplateService;
use App\Services\NotificationService;

class SellerProductController extends Controller
{

    public function index(Request $request, Sellers $seller)
    {
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $activeTab = $request->get('status', '1');

        $products = Products::with(
            'categorySections.category',
            'subCategory',
            'primaryVariantImage',
            'visualImages'
        )
            ->where('seller_id', $seller->id)
            ->when(in_array($activeTab, ['0', '1', '2'], true), function ($query) use ($activeTab) {
                $query->where('is_approved', $activeTab);
            })
            ->orderBy('id', 'desc')
            ->paginate(7);

        $categories = ProductCategory::select('id', 'name', 'slug')->get();
        $brands = Brands::select('id', 'name')->get();
        $hasBulkActivity = DB::table('ingestion_batches')->where('seller_id', $seller->id)->exists();

        return view('seller.products.index', compact('products', 'seller', 'activeTab', 'categories', 'brands', 'hasBulkActivity'));
    }

    public function bulkSubcategories(Request $request)
    {
        return ProductSubCategory::whereIn('product_categories_id', $request->categories)->select('id', 'name', 'product_categories_id')->get();
    }


    public function create(Sellers $seller)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $id = $seller->id;
        // Fetch category hierarchy
        $categoryTree = MasterCategorySection::with(['masterCategory', 'sectionType', 'category'])->get();
        // Classified categories
        $productCategories = ProductCategory::with([
            'subCategories' => function ($q) {
                $q->where('status', 1);
            }
        ])
            ->where('status', 1)
            ->get();

        $selectedCategoryId = null;
        $selectedSubCategoryId = null;

        return view('seller.products.create', compact(
            'categoryTree',
            'id',
            'seller',
            'productCategories',
            'selectedCategoryId',
            'selectedSubCategoryId'
        ));
    }


    public function store(Request $request, Sellers $seller)
    {

        // ✅ Security check
        if (auth('seller')->id() !== $seller->id) {
            abort(403);
        }


        $this->normalizeVariantSkus($request);

        $isDraft = $request->input('product_action') === 'draft';

        // ✅ Validation aligned with admin + draft flexibility
        $isDraft = $request->input('product_action') === 'draft';

        $validated = $request->validate([

            'product_categories_id' => [$isDraft ? 'nullable' : 'required', 'exists:product_categories,id'],
            'product_sub_categories_id' => [$isDraft ? 'nullable' : 'required', 'exists:product_sub_categories,id'],

            'name' => [$isDraft ? 'nullable' : 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'price' => [$isDraft ? 'nullable' : 'required', 'numeric', 'min:99'],
            'stock' => ['nullable', 'integer', 'min:0'],

            'master_category_section_id' => [$isDraft ? 'nullable' : 'required', 'array', 'min:1'],
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

            'youtube_url' => ['nullable', 'url'],
        ]);

        $this->assertUniqueVariantSkusForCreate($validated['variants'] ?? []);

        // ✅ Image validation (same as admin but draft-safe)
        $visualImages = $request->file('visual_images', []);
        $hasVisualImages = collect($visualImages)
            ->flatten(1)
            ->filter(fn($file) => $file instanceof \Illuminate\Http\UploadedFile)
            ->isNotEmpty();

        if (!$isDraft) {
            if ($hasVisualImages) {
                foreach ($visualImages as $files) {
                    if (count($files) < 3) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Each visual variant must have at least 3 images.'
                        ], 422);
                    }
                }
            } else {
                if (!$request->hasFile('images') || count($request->file('images')) < 3) {
                    return response()->json([
                        'success' => false,
                        'message' => 'At least 3 product images are required.'
                    ], 422);
                }
            }
        }

        DB::beginTransaction();

        try {

            // ✅ Create product
            $product = Products::create([
                'product_code' => $validated['product_categories_id']
                    ? ProductCodeService::generate($validated['product_categories_id'])
                    : null,

                'seller_id' => $seller->id,

                'product_categories_id' => $validated['product_categories_id'] ?? null,
                'product_sub_categories_id' => $validated['product_sub_categories_id'] ?? null,

                'name' => $validated['name'] ?? 'Draft Product',
                'description' => $validated['description'] ?? null,

                'slug' => Str::slug($validated['name'] ?? 'draft-product') . '-' . Str::random(6),

                'price' => $validated['price'] ?? 0,
                'stock' => $validated['stock'] ?? 0,

                'featured' => 0,
                'is_approved' => 0,
                'status' => $isDraft ? 0 : 1,

                'youtube_url' => $validated['youtube_url'] ?? null,
            ]);

            // ✅ ATTRIBUTES
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

            // ✅ VARIANTS
            if (!empty($validated['variants'])) {
                foreach ($validated['variants'] as $variantData) {

                    $enabled = filter_var($variantData['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
                    if (!$enabled)
                        continue;

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
                    foreach (array_unique($variantData['values'] ?? []) as $valueId) {
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

            // ✅ SIMPLE PRODUCT IMAGES
            if (!$hasVisualImages && $request->hasFile('images')) {
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

            // ✅ VISUAL VARIANT IMAGES
            if (!empty($validated['visual_images'])) {
                foreach ($request->file('visual_images') as $attributeValueId => $images) {
                    $isPrimary = true;
                    $sortOrder = ProductAttributeValueImage::where('product_id', $product->id)
                        ->where('attribute_value_id', $attributeValueId)
                        ->max('sort_order') ?? 0;

                    foreach ($images as $image) {
                        $path = $image->store('products/variants/' . date('Y/m'), 'public');

                        ProductAttributeValueImage::create([
                            'product_id' => $product->id,
                            'attribute_value_id' => $attributeValueId,
                            'image_path' => $path,
                            'is_primary' => $isPrimary ? 1 : 0,
                            'sort_order' => ++$sortOrder
                        ]);

                        $isPrimary = false;
                    }
                }
            }

            // ✅ CATEGORY PLACEMENT
            if (!empty($validated['master_category_section_id'])) {
                $rows = [];
                foreach ($validated['master_category_section_id'] as $sectionId) {
                    $rows[] = [
                        'product_id' => $product->id,
                        'master_category_section_id' => $sectionId
                    ];
                }
                ProductCategorySection::insert($rows);
            }

            DB::commit();

            if (!$isDraft) {
                $sellerPayload = NotificationTemplateService::sellerProductAdded($product);

                NotificationService::create([
                    'receiver_id' => $seller->id,
                    'receiver_type' => 'seller',
                    'title' => $sellerPayload['title'],
                    'message' => $sellerPayload['message'],
                    'details' => $sellerPayload['details'],
                    'type' => $sellerPayload['type'],
                    'image' => $sellerPayload['image'],
                    'reference_id' => $sellerPayload['reference_id'],
                    'is_read' => false,
                ]);
            }

            // admin notification
            if (!$isDraft) {
                $admins = NotificationRecipientResolver::admins();

                $template = NotificationTemplateService::productPending($product);

                NotificationService::notifyMany(
                    $admins,
                    $template,
                    'admin_user'
                );
            }

            return response()->json([
                'success' => true,
                'redirect' => route('seller.products.index', $seller->slug),
                'message' => $isDraft
                    ? 'Product draft saved successfully'
                    : 'Product added successfully'
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while saving the product.'
            ], 500);
        }
    }


    public function search(Request $request, Sellers $seller)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $search = $request->search;
        $status = $request->status;
        $activeTab = $request->get('active_tab', '1');

        if ($request->boolean('suggestions')) {
            $products = Products::with(['primaryImage', 'primaryVariantImage', 'visualImages', 'variants.values'])
                ->where('seller_id', $seller->id)
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('price', 'LIKE', "%{$search}%")
                            ->orWhere('stock', 'LIKE', "%{$search}%")
                            ->orWhereHas('variants', function ($variantQuery) use ($search) {
                                $variantQuery->where('price', 'LIKE', "%{$search}%")
                                    ->orWhere('stock', 'LIKE', "%{$search}%")
                                    ->orWhereHas('values', function ($valueQuery) use ($search) {
                                        $valueQuery->where('value', 'LIKE', "%{$search}%");
                                    });
                            });
                    });
                })
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($product) {
                    $tab = (string) ($product->is_approved ?? '1');
                    $image = $product->primaryImage
                        ?? $product->primaryVariantImage
                        ?? $product->images->first()
                        ?? $product->visualImages->first();

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'tab' => $tab,
                        'status' => $product->is_approved,
                        'image' => $image ? asset('storage/' . $image->image_path) : null,
                    ];
                })
                ->values();

            return response()->json(['success' => true, 'items' => $products]);
        }

        $products = Products::with('categorySections.category')
            ->where('seller_id', $seller->id)
            ->when(in_array($activeTab, ['0', '1', '2'], true), function ($query) use ($activeTab) {
                $query->where('is_approved', $activeTab);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('price', 'LIKE', "%{$search}%")
                        ->orWhere('stock', 'LIKE', "%{$search}%")
                        ->orWhereHas('variants', function ($variantQuery) use ($search) {
                            $variantQuery->where('price', 'LIKE', "%{$search}%")
                                ->orWhere('stock', 'LIKE', "%{$search}%")
                                ->orWhereHas('values', function ($valueQuery) use ($search) {
                                    $valueQuery->where('value', 'LIKE', "%{$search}%");
                                });
                        })
                        ->orWhereHas('categorySections.category', function ($qq) use ($search) {
                            $qq->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_approved', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        if ($request->ajax()) {
            return view('seller.products.partials.table-container', compact('products', 'seller', 'activeTab'))->render();
        }

        return view('seller.products.index', compact('products', 'seller', 'activeTab'));
    }


    public function edit(Sellers $seller, $productId)
    {
        // ✅ Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $id = $seller->id;

        // ✅ Fetch product (SECURE)
        $product = Products::with([
            'images',
            'variants.values',
            'attributeValues.attributeValue',
            'categorySections.masterCategorySection',
            'visualImages.attributeValue'
        ])
            ->where('seller_id', $seller->id) // 🔥 IMPORTANT FIX
            ->findOrFail($productId);

        // ✅ Category Tree
        $categoryTree = MasterCategorySection::with([
            'masterCategory',
            'sectionType',
            'category'
        ])->get();

        // ✅ Product Categories + Subcategories
        $productCategories = ProductCategory::with([
            'subCategories' => function ($q) {
                $q->where('status', 1);
            }
        ])
            ->where('status', 1)
            ->get();

        // ✅ GET SELECTED CATEGORY ID (IMPORTANT FIX)
        $selectedCategoryId = $product->product_categories_id;
        $selectedSubCategoryId = $product->product_sub_categories_id;

        return view('seller.products.edit', compact(
            'product',
            'id',
            'categoryTree',
            'seller',
            'productCategories',
            'selectedCategoryId',
            'selectedSubCategoryId'
        ));
    }


    public function update(Request $request, Sellers $seller, $id)
    {
        // ✅ Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $product = Products::where('seller_id', $seller->id)->findOrFail($id);

        $this->normalizeVariantSkus($request);

        // ✅ Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'brand_info' => 'nullable|string',
            'youtube_url' => 'nullable|url',
            'cancellation_policy' => 'nullable|string',

            // ✅ Category validation
            'product_categories_id' => 'required|exists:product_categories,id',
            'product_sub_categories_id' => 'required|exists:product_sub_categories,id',
            'master_category_section_id' => 'required|array|min:1',
            'master_category_section_id.*' => 'exists:master_category_sections,id',

            'attributes' => 'nullable|array',
            'attributes.*' => 'array',
            'attributes.*.*' => 'exists:attribute_values,id',

            'variants' => 'nullable|array',
            'variants.*.enabled' => 'nullable|boolean',
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.values' => 'required_with:variants|array',
            'variants.*.values.*' => 'exists:attribute_values,id',

            'existing_images' => 'nullable|array',
            'existing_images.*' => 'integer|exists:product_images,id',

            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:500',
            'visual_images' => 'nullable|array',
            'visual_images.*' => 'array',
            'visual_images.*.*' => 'image|mimes:jpeg,jpg,png|max:500',
            'visual_images_removed' => 'nullable|string',
        ]);

        $existingVariantsForSkuCheck = ProductVariant::with('values')
            ->where('product_id', $product->id)->get();

        $existingMapForSkuCheck = [];
        foreach ($existingVariantsForSkuCheck as $variant) {
            $key = $variant->values->pluck('id')->sort()->implode('-');
            $existingMapForSkuCheck[$key] = $variant;
        }

        $this->assertUniqueVariantSkusForUpdate($validated['variants'] ?? [], $existingMapForSkuCheck);

        DB::beginTransaction();

        try {

            // ✅ Update product
            $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'stock' => $validated['stock'] ?? 0,
                'short_description' => $validated['short_description'] ?? null,
                'description' => $request->input('description', $product->description),
                'brand_info' => $request->input('brand_info', $product->brand_info),
                'youtube_url' => $validated['youtube_url'] ?? null,
                'cancellation_policy' => $request->input('cancellation_policy', $product->cancellation_policy),
                'product_categories_id' => $validated['product_categories_id'],
                'product_sub_categories_id' => $validated['product_sub_categories_id'],
            ]);

            // ✅ REMOVE OLD CATEGORY LINKS
            $product->categorySections()->delete();

            // ✅ SAVE WEBSITE CATEGORY PLACEMENT
            foreach ($validated['master_category_section_id'] as $sectionId) {
                ProductCategorySection::create([
                    'product_id' => $product->id,
                    'master_category_section_id' => $sectionId,
                ]);
            }

            // ✅ Handle existing images
            // âœ… ATTRIBUTES
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
                if (!empty($rows)) {
                    ProductAttributeValue::insert($rows);
                }
            }

            // âœ… VARIANTS (UPSERT BY VALUES KEY)
            $existingVariants = ProductVariant::with('values')
                ->where('product_id', $product->id)->get();

            $existingMap = [];
            foreach ($existingVariants as $variant) {
                $key = $variant->values->pluck('id')->sort()->implode('-');
                $existingMap[$key] = $variant;
            }

            foreach ($validated['variants'] ?? [] as $variantData) {

                $key = collect($variantData['values'] ?? [])
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
                        'status' => 1,
                    ]);
                    continue;
                }

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $sku,
                    'price' => $variantData['price'] ?? $product->price,
                    'stock' => $variantData['stock'] ?? 0,
                    'status' => 1,
                ]);

                $rows = [];
                foreach (array_unique($variantData['values'] ?? []) as $valueId) {
                    $rows[] = [
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $valueId
                    ];
                }

                if (!empty($rows)) {
                    VariantAttributeValue::insert($rows);
                }
            }

            $existingImageIds = $validated['existing_images'] ?? $request->input('existing_images', []);
            $product->images()->whereNotIn('id', $existingImageIds)->delete();

            // ✅ Handle new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products/' . date('Y/m'), 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => 0,
                    ]);
                }
            }

            // ✅ Handle visual variant images
            if ($request->filled('visual_images_removed')) {
                $ids = json_decode($request->visual_images_removed, true);
                if (is_array($ids) && !empty($ids)) {
                    $ids = array_values(array_filter(array_map('intval', $ids)));
                    $images = ProductAttributeValueImage::where('product_id', $product->id)
                        ->whereIn('id', $ids)
                        ->get();

                    foreach ($images as $img) {
                        if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                            Storage::disk('public')->delete($img->image_path);
                        }
                        $img->delete();
                    }
                }
            }

            if ($request->hasFile('visual_images')) {
                foreach ($request->file('visual_images') as $attributeValueId => $images) {
                    $isPrimary = true;
                    $sortOrder = 0;

                    foreach ($images as $image) {
                        $path = $image->store('products/variants/' . date('Y/m'), 'public');

                        ProductAttributeValueImage::create([
                            'product_id' => $product->id,
                            'attribute_value_id' => $attributeValueId,
                            'image_path' => $path,
                            'is_primary' => 0,
                            'sort_order' => ++$sortOrder,
                        ]);
                    }
                }
            }

            // ✅ Ensure primary image
            // ensure primary per attribute value
            $grouped = ProductAttributeValueImage::where('product_id', $product->id)
                ->get()->groupBy('attribute_value_id');

            foreach ($grouped as $valueId => $images) {
                if (!$images->where('is_primary', 1)->count()) {
                    ProductAttributeValueImage::where('id', $images->first()->id)
                        ->update(['is_primary' => 1]);
                }
            }

            $this->ensurePrimaryImage($product);

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('seller.products.index', $seller->slug)
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function updatePrice(Request $request, Sellers $seller, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'mode' => 'required'
        ]);

        // ======================
        // VARIANT
        // ======================

        if ($request->mode === 'variant') {

            $variant = ProductVariant::findOrFail($id);

            $variant->update([
                'price' => $request->price
            ]);

            return response()->json([
                'success' => true
            ]);
        }

        // ======================
        // SIMPLE PRODUCT
        // ======================

        if ($request->mode === 'product') {

            $product = Products::findOrFail($id);

            $product->update([
                'price' => $request->price
            ]);

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }



    public function updateStock(Request $request, Sellers $seller, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
            'mode' => 'required'
        ]);

        // ======================
        // VARIANT
        // ======================

        if ($request->mode === 'variant') {

            $variant = ProductVariant::findOrFail($id);

            $variant->update([
                'stock' => $request->stock
            ]);

            return response()->json([
                'success' => true
            ]);
        }

        // ======================
        // SIMPLE PRODUCT
        // ======================

        if ($request->mode === 'product') {

            $product = Products::findOrFail($id);

            $product->update([
                'stock' => $request->stock
            ]);

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }



    public function toggleFeatured(Request $request, Sellers $seller, $id)
    {
        $type = $request->input('type');

        // reset all products
        Products::where('seller_id', $seller->id)
            ->update([
                'featured' => 0
            ]);

        // reset all variants
        ProductVariant::whereHas('product', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->update([
            'is_featured' => 0
        ]);

        // =========================
        // VARIANT FEATURE
        // =========================

        if ($type == 'variant') {

            $variant = ProductVariant::whereHas('product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })->findOrFail($id);

            $variant->is_featured = 1;
            $variant->save();

            return response()->json([
                'success' => true,
                'type' => 'variant'
            ]);
        }

        // =========================
        // SIMPLE PRODUCT FEATURE
        // =========================

        if ($type == 'product') {

            $product = Products::where('seller_id', $seller->id)
                ->findOrFail($id);

            $product->featured = 1;
            $product->save();

            return response()->json([
                'success' => true,
                'type' => 'product'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid type'
        ], 400);
    }

    private function ensurePrimaryImage($product)
    {
        $images = $product->images()->get();
        if ($images->count() > 0) {
            if (!$images->where('is_primary', 1)->first()) {
                $firstImage = $images->first();
                $firstImage->is_primary = 1;
                $firstImage->save();
            }
        }
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

    public function destroy(Sellers $seller, $productId)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $id = $seller->id;

        $product = Products::where('seller_id', $id)
            ->findOrFail($productId);

        $product->delete();

        return redirect()
            ->route('seller.products.index', $seller->slug)
            ->with('success', 'Product deleted successfully.');
    }



    public function checkBankDetails($slug, $type)
    {
        $seller = Sellers::where('slug', $slug)->firstOrFail();

        if (
            empty($seller->bankDetail) ||
            empty(optional($seller->bankDetail)->bank_name) ||
            empty(optional($seller->bankDetail)->account_number) ||
            empty(optional($seller->bankDetail)->ifsc_code)
        ) {
            return redirect()->route('seller.bank.details.form', [
                'seller' => $seller->slug,
                'type' => $type,
            ]);
        }

        return $type === 'bulk'
            ? redirect()->route('seller.products.bulk.create', ['seller' => $seller->slug])
            : redirect()->route('seller.products.create', ['seller' => $seller->slug]);
    }

    public function showBankDetailsForm($sellerSlug, $type)
    {
        $seller = Sellers::where('slug', $sellerSlug)->firstOrFail();

        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        return view('seller.bank-details', [
            'seller' => $seller,
            'type' => $type,
            'bank' => $seller->bankDetail
        ]);
    }


    public function storeBankDetails(Request $request, $sellerSlug, $type)
    {
        $seller = Sellers::where('slug', $sellerSlug)->firstOrFail();

        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $validated = $request->validate([
            'account_holder_name' => ['required', 'string', 'max:255'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50', 'same:confirm_account_number'],
            'confirm_account_number' => ['required', 'string', 'max:50'],
            'ifsc_code' => ['required', 'string', 'size:11', 'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/'],
        ]);

        SellerBankDetail::updateOrCreate(
            ['seller_id' => $seller->id],
            [
                'account_holder_name' => $validated['account_holder_name'],
                'bank_name' => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'ifsc_code' => strtoupper($validated['ifsc_code']),
            ]
        );

        $redirect = $type === 'bulk'
            ? route('seller.products.bulk.create', $seller->slug)
            : route('seller.products.create', $seller->slug);

        return redirect($redirect)->with('success', 'Bank details saved successfully.');
    }




    public function bulkCreate($sellerSlug)
    {
        $seller = Sellers::where('slug', $sellerSlug)->firstOrFail();



        return view('seller.products.bulk.create', compact('seller'));
    }
}
