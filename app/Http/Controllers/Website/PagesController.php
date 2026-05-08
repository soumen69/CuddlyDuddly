<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Website\HomeSection;
use App\Models\MasterCategory;
use App\Models\SectionType;
use App\Models\Category;
use App\Models\MasterCategorySection;
use App\Models\AttributeValue;
use App\Models\ProductImage;
use App\Models\ProductAttributeValueImage;
use App\Models\Products;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Services\Shipping\ShiprocketService;
use App\Models\ShippingAddress;
use App\Models\Cart;
use App\Services\CategoryFilterService;

class PagesController extends Controller
{

    public function index()
    {
        $sections = HomeSection::active()
            ->ordered()
            ->get();
        return view('website.home', compact('sections'));
    }

    public function show(MasterCategory $master, SectionType $sectionType, Category $category)
    {
        // 1️⃣ Get full ordered chain inside this master
        $allChains = MasterCategorySection::where('master_category_id', $master->id)
            ->with(['category', 'sectionType'])
            ->orderBy('position')
            ->get()
            ->values();

        if ($allChains->isEmpty()) {
            abort(404);
        }

        $currentIndex = $allChains->search(function ($item) use ($sectionType, $category) {
            return $item->section_type_id == $sectionType->id
                && $item->category_id == $category->id;
        });

        if ($currentIndex === false) {
            abort(404);
        }

        $currentChain = $allChains[$currentIndex];

        // 3️⃣ Circular 8 tabs logic
        $total = $allChains->count();
        $tabsCollection = collect();

        for ($i = 0; $i < min(15, $total); $i++) {
            $index = ($currentIndex + $i) % $total;
            $tabsCollection->push($allChains[$index]);
        }

        // 4️⃣ Build tabs (ONLY FIRST TAB PRODUCTS LOADED)
        $tabs = $tabsCollection->map(function ($chain, $index) use ($master) {
            $products = [];

            // Load products only for first tab
            if ($index === 0) {

                $products = Products::query()
                    ->whereHas('categorySections', function ($q) use ($chain) {
                        $q->where('master_category_section_id', $chain->id);
                    })
                    ->approvedAndFeatured()
                    ->withAvg('reviews', 'rating')
                    ->with(['primaryImage', 'variants.attributeValues.attributeValue.attribute'])
                    ->get()
                    ->filter()
                    ->map(function ($product) {

                        // 🔥 pick first variant image if exists
                        $variantImage = null;

                        foreach ($product->variants as $variant) {
                            foreach ($variant->attributeValues as $v) {
                                if ($v->attributeValue->attribute->is_visual) {

                                    $img = ProductAttributeValueImage::where([
                                        'product_id' => $product->id,
                                        'attribute_value_id' => $v->attribute_value_id,
                                        'is_primary' => 1
                                    ])->first();

                                    if ($img) {
                                        $variantImage = asset('storage/' . $img->image_path);
                                        break 2;
                                    }
                                }
                            }
                        }

                        $groupedVariants = [
                            'visual' => [],
                            'text'   => []
                        ];

                        foreach ($product->variants as $variant) {
                            foreach ($variant->attributeValues as $v) {

                                $attr = $v->attributeValue->attribute;

                                if (!$attr->is_variant) continue;

                                $item = [
                                    'value'      => $v->attributeValue->value,
                                    'variant_id' => $variant->id,
                                    'attribute'  => $attr->name,
                                ];

                                if ($attr->is_visual) {
                                    $groupedVariants['visual'][$attr->name][] = $item;
                                } else {
                                    $groupedVariants['text'][$attr->name][] = $item;
                                }
                            }
                        }

                        // 🔥 Remove duplicates per attribute
                        $groupedVariants['visual'] = collect($groupedVariants['visual'])
                            ->map(fn($items) => collect($items)->unique('value')->values());

                        $groupedVariants['text'] = collect($groupedVariants['text'])
                            ->map(fn($items) => collect($items)->unique('value')->values());

                        return [
                            'id'         => $product->id,
                            'name'       => $product->name,
                            'slug'       => $product->slug,
                            'info'       => $product->short_description ?? '',
                            'review'     => number_format(round($product->reviews_avg_rating ?? 0, 1), 1),
                            'discounted' => '₹' . number_format($product->discount_price ?? $product->price),
                            'price'      => '₹' . number_format($product->price),
                            'image' => $variantImage
                                ?? ($product->primaryImage
                                    ? asset('storage/' . $product->primaryImage->image_path)
                                    : asset('images/default.png')),

                            // 🔥 HYBRID DATA
                            'has_variants'   => $product->variants->count() > 0,
                            'variants_grouped' => $groupedVariants,
                        ];
                    })
                    ->values();
            }

            return [
                'name'        => $chain->category->name,
                'slug'        => $chain->category->slug,
                'sectionSlug' => $chain->sectionType->slug,
                'icon'        => asset('storage/WebsiteImages/category/icon1.png'),
                'products'    => $products, // empty for others
            ];
        });

        $currentTabCount = count($tabs[0]['products']);

        $totalProductsCount = Products::where(
            'product_categories_id',
            $category->product_categories_id
        )->count();

        $filters = app(CategoryFilterService::class)
            ->getFilters(
                $category->product_categories_id, // classified
                $currentChain->id                 // exact hierarchy row
            );
        // $filters = app(CategoryFilterService::class)
        //     ->getFilters(
        //         $category->id, // ✅ CORRECT
        //         $currentChain->id
        //     );

        // var_dump($filters);exit;
        return view('website.categories', compact(
            'master',
            'sectionType',
            'category',
            'tabs',
            'totalProductsCount',
            'currentTabCount',
            'filters'
        ));
    }

    public function loadTabProducts(MasterCategory $master, SectionType $section, Category $category)
    {
        $chain = MasterCategorySection::findByHierarchy(
            $master->id,
            $section->id,
            $category->id
        );

        $products = Products::query()
            ->whereHas('categorySections', function ($q) use ($chain) {
                $q->where('master_category_section_id', $chain->id);
            })
            ->approvedAndFeatured()
            ->where('status', 1)
            ->withAvg('reviews', 'rating')
            ->with([
                'primaryImage',
                'variants.attributeValues.attributeValue.attribute'
            ])->get()
            ->map(function ($product) {

                // 🔥 pick variant image
                $variantImage = null;

                foreach ($product->variants as $variant) {
                    foreach ($variant->attributeValues as $v) {
                        if ($v->attributeValue->attribute->is_visual) {

                            $img = ProductAttributeValueImage::where([
                                'product_id' => $product->id,
                                'attribute_value_id' => $v->attribute_value_id,
                                'is_primary' => 1
                            ])->first();

                            if ($img) {
                                $variantImage = asset('storage/' . $img->image_path);
                                break 2;
                            }
                        }
                    }
                }

                // 🔥 GROUPED VARIANTS (FIXED STRUCTURE)
                $groupedVariants = [
                    'visual' => [],
                    'text'   => []
                ];

                foreach ($product->variants as $variant) {
                    foreach ($variant->attributeValues as $v) {

                        $attr = $v->attributeValue->attribute;

                        if (!$attr->is_variant) continue;

                        $item = [
                            'value'      => $v->attributeValue->value,
                            'variant_id' => $variant->id,
                            'attribute'  => $attr->name,
                        ];

                        if ($attr->is_visual) {
                            $groupedVariants['visual'][$attr->name][] = $item;
                        } else {
                            $groupedVariants['text'][$attr->name][] = $item;
                        }
                    }
                }

                // 🔥 REMOVE DUPLICATES
                $groupedVariants['visual'] = collect($groupedVariants['visual'])
                    ->map(fn($items) => collect($items)->unique('value')->values());

                $groupedVariants['text'] = collect($groupedVariants['text'])
                    ->map(fn($items) => collect($items)->unique('value')->values());

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'info' => $product->short_description ?? '',
                    'review' => number_format(round($product->reviews_avg_rating ?? 0, 1), 1),
                    'discounted' => '₹' . number_format($product->discount_price ?? $product->price),
                    'price' => '₹' . number_format($product->price),

                    // 🔥 IMAGE
                    'image' => $variantImage
                        ?? ($product->primaryImage
                            ? asset('storage/' . $product->primaryImage->image_path)
                            : asset('images/default.png')),

                    // 🔥 IMPORTANT
                    'has_variants'      => $product->variants->count() > 0,
                    'variants_grouped'  => $groupedVariants,
                ];
            })
            ->values();


        // SAME logic as show() method
        $filters = app(CategoryFilterService::class)
            ->getFilters(
                $category->product_categories_id,
                $chain->id
            );

        $filtersHtml = view('website.partials.category-filters', compact('filters'))->render();

        return response()->json([
            'products' => $products,
            'filtersHtml' => $filtersHtml
        ]);
    }

    public function productDetails($slug)
    {
        $product = Products::with([
            'brand',
            'productCategory',
            'subCategory',
            'images' => fn($q) => $q->orderByDesc('is_primary')->orderBy('id'),
            'variants' => fn($q) => $q->where('status', 1)->with('values.attribute'),
            'attributeValues.attributeValue.attribute',
            'visualAttributeImages.attributeValue.attribute'
        ])
            ->approvedAndFeatured()
            ->where('slug', $slug)
            ->firstOrFail();

        /* ================= ATTRIBUTE PROCESSING ================= */

        $allAttributes = $product->attributeValues;

        $specifications = $allAttributes
            ->filter(fn($pav) => !$pav->attributeValue->attribute->is_variant)
            ->sortBy(fn($pav) => $pav->attributeValue->attribute->id)
            ->values();

        $variantAttributes = [];
        $variantMatrix = [];
        $visualImageMap = [];

        $hasVariants = $product->variants->isNotEmpty();
        $defaultVariant = $hasVariants ? $product->variants->first() : null;

        if ($hasVariants) {

            foreach ($product->variants as $variant) {
                foreach ($variant->values as $value) {
                    $variantMatrix[$variant->id][$value->attribute->id] = $value->id;
                }
            }

            foreach ($allAttributes as $pav) {

                $attr = $pav->attributeValue->attribute;

                if (!$attr->is_variant) continue;

                $variantAttributes[$attr->id]['attribute'] = $attr;
                $variantAttributes[$attr->id]['values'][] = $pav->attributeValue;
            }

            foreach ($product->visualAttributeImages as $img) {
                $visualImageMap[$img->attribute_value_id][] = $img;
            }
        }

        /* ================= REVIEW (OPTIMIZED) ================= */

        $reviewAgg = Review::selectRaw("
        COUNT(*) as total,
        ROUND(AVG(rating),1) as avg_rating,
        SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as r5,
        SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as r4,
        SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as r3,
        SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as r2,
        SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as r1")
            ->where('product_id', $product->id)
            ->first();

        $reviewStats = [
            'avg' => $reviewAgg->avg_rating ?? 0,
            'count' => $reviewAgg->total ?? 0,
            'distribution' => [
                5 => $reviewAgg->r5 ?? 0,
                4 => $reviewAgg->r4 ?? 0,
                3 => $reviewAgg->r3 ?? 0,
                2 => $reviewAgg->r2 ?? 0,
                1 => $reviewAgg->r1 ?? 0,
            ]
        ];

        $latestReviews = Review::where('product_id', $product->id)
            ->latest()
            ->limit(5)
            ->with('customer.defaultShippingAddress')
            ->get();

        $currentUserReview = auth('customer')->check()
            ? Review::where('product_id', $product->id)
            ->where('user_id', auth('customer')->id())
            ->first()
            : null;

        /* ================= INITIAL IMAGE ================= */

        $initialImages = $product->images;

        if ($hasVariants && $defaultVariant) {
            $visualValue = $defaultVariant->values
                ->firstWhere(fn($v) => $v->attribute->is_visual);

            if ($visualValue && isset($visualImageMap[$visualValue->id])) {
                $initialImages = $visualImageMap[$visualValue->id];
            }
        }


        // ================= RELATED PRODUCTS (FIXED) =================

        $relatedProducts = Products::with(['images', 'brand'])
            ->approvedAndFeatured()
            ->where('id', '!=', $product->id)
            ->where('product_sub_categories_id', $product->product_sub_categories_id)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        // fallback to category
        if ($relatedProducts->count() < 8) {

            $additional = Products::with(['images', 'brand'])
                ->approvedAndFeatured()
                ->where('id', '!=', $product->id)
                ->where('product_categories_id', $product->product_categories_id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->inRandomOrder()
                ->limit(8 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->merge($additional);
        }

        // $relatedProductsFormatted = $relatedProducts->map(function ($p) {
        //     $image = optional($p->images->first())->image_path ?? 'fallback.png';
        //     return [
        //         'url' => route('product.details', $p->slug),
        //         'image' => 'storage/' . $image,
        //         'name' => $p->name,
        //         'subtitle' => $p->brand->name ?? '',
        //         'rating' => '4.5',
        //         'mrp' => $p->price,
        //         'price' => $p->discount_price ?? $p->price,
        //     ];
        // });

        $relatedProductsFormatted = collect();

        foreach ($relatedProducts as $p) {

            $p->loadMissing([
                'images',
                'variants.values.attribute',
                'visualAttributeImages'
            ]);

            // ================= REVIEW (PRODUCT LEVEL) =================
            $reviewAgg = Review::selectRaw("
        COUNT(*) as total,
        ROUND(AVG(rating),1) as avg_rating
    ")
                ->where('product_id', $p->id)
                ->first();

            $rating = $reviewAgg->avg_rating ?? 0;

            // ================= DEFAULT IMAGE =================
            $image = optional(
                $p->images->sortByDesc('is_primary')->first()
            )->image_path;

            // ================= CHECK VISUAL VARIANT =================
            $selectedVariantId = null;

            if ($p->variants->isNotEmpty()) {

                foreach ($p->variants as $variant) {

                    $visualValue = $variant->values
                        ->firstWhere(fn($v) => $v->attribute->is_visual);

                    if ($visualValue) {

                        $variantImage = optional(
                            $p->visualAttributeImages
                                ->where('attribute_value_id', $visualValue->id)
                                ->sortByDesc('is_primary')
                                ->first()
                        )->image_path;

                        if ($variantImage) {
                            $image = $variantImage;
                            $selectedVariantId = $variant->id; // for PDP preselect
                            break; // take first visual variant only
                        }
                    }
                }
            }

            // fallback safety
            $image = $image ?? 'fallback.png';

            $relatedProductsFormatted->push([
                'url' => route('product.details', $p->slug) .
                    ($selectedVariantId ? '?variant=' . $selectedVariantId : ''),

                'image' => 'storage/' . $image,
                'name' => $p->name,
                'subtitle' => $p->brand->name ?? '',
                'rating' => $rating,

                'mrp' => $p->price,
                'price' => $p->discount_price ?? $p->price,
            ]);
        }

        return view('website.product-details', compact(
            'product',
            'hasVariants',
            'defaultVariant',
            'variantMatrix',
            'variantAttributes',
            'visualImageMap',
            'reviewStats',
            'latestReviews',
            'initialImages',
            'currentUserReview',
            'specifications',
            'relatedProductsFormatted'
        ));
    }


    public function checkPincode(Request $request, ShiprocketService $shiprocket)
    {
        $request->validate([
            'pincode' => 'required|digits:6'
        ]);

        try {
            $result = $shiprocket->checkPincode($request->pincode);

            if (!$result['serviceable']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Delivery not available in your area'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Delivery in {$result['delivery_days']} days",
                'cod' => $result['cod']
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to check delivery right now'
            ]);
        }
    }

    public function resolveVariant(Request $request)
    {
        $productId = $request->product_id;
        $selectedValues = $request->attribute_value_ids; // array

        $variant = ProductVariant::where('product_id', $productId)
            ->where('status', 1)
            ->whereHas('values', function ($q) use ($selectedValues) {
                $q->whereIn('attribute_value_id', $selectedValues);
            }, '=', count($selectedValues))
            ->with('values.attribute')
            ->first();

        if (!$variant) {
            return response()->json([
                'success' => false
            ]);
        }

        // ===== VISUAL IMAGE RESOLVE =====
        $visualValue = AttributeValue::whereIn('id', $selectedValues)
            ->whereHas('attribute', fn($q) => $q->where('is_visual', 1))
            ->first();

        if ($visualValue) {
            $images = ProductAttributeValueImage::where([
                'product_id' => $productId,
                'attribute_value_id' => $visualValue->id
            ])->orderBy('sort_order')->get();
        } else {
            $images = ProductImage::where('product_id', $productId)->get();
        }

        return response()->json([
            'success' => true,
            'variant_id' => $variant->id,
            'price' => $variant->price,
            'compare_price' => $variant->compare_price,
            'stock' => $variant->stock,
            'in_stock' => $variant->stock > 0,
            'images' => $images
        ]);
    }


    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'qty' => 'required|integer|min:1|max:10',
            'buy_now' => 'nullable|boolean'
        ]);

        $userId = auth('customer')->id();

        $product = Products::findOrFail($request->product_id);

        $variant = null;

        // ✅ VARIANT VALIDATION
        if ($request->variant_id) {

            $variant = ProductVariant::where('id', $request->variant_id)
                ->where('product_id', $product->id)
                ->first();

            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid variant selected'
                ]);
            }

            if ($variant->stock < $request->qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock'
                ]);
            }
        } else {

            if ($product->stock < $request->qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock'
                ]);
            }
        }

        // 🔥 BUY NOW → CLEAR EXISTING CART
        if ($request->buy_now) {
            Cart::where('user_id', $userId)
                ->where('is_ordered', false)
                ->delete();
        }

        // 🔥 CHECK EXISTING CART ITEM
        $cartItem = Cart::where([
            'user_id' => $userId,
            'product_id' => $product->id,
            'variant_id' => $variant?->id,
            'is_ordered' => false
        ])->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->qty;
            $availableStock = $variant?->stock ?? $product->stock;
            if ($newQty > $availableStock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock limit exceeded'
                ]);
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            // ✅ CREATE NEW
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'quantity' => $request->qty,
                'is_ordered' => false
            ]);
        }

        $cartSummary = $this->getCartSummary($userId);

        return response()->json([
            'success' => true,
            'redirect' => $request->buy_now ? route('cart') : null,
            'cart' => $cartSummary
        ]);
    }

    public function cart()
    {
        $userId = auth('customer')->id();

        $cartItems = Cart::with([
            'product.images',
            'variant.values.attribute'
        ])
            ->where('user_id', $userId)
            ->where('is_ordered', false)
            ->get()
            ->map(function ($item) {

                $product = $item->product;
                $variant = $item->variant;

                $price = $variant?->price ?? $product->price;
                $attributes = [];

                if ($variant) {
                    foreach ($variant->values as $value) {
                        $attributes[] = [
                            'name' => $value->attribute->name,
                            'value' => $value->value
                        ];
                    }
                }

                $imagePath = null;

                if ($variant && $variant->values->isNotEmpty()) {
                    foreach ($variant->values as $value) {
                        if ($value->attribute->is_visual) {
                            $image = ProductAttributeValueImage::where('product_id', $product->id)
                                ->where('attribute_value_id', $value->id)
                                ->orderByDesc('is_primary')
                                ->first();
                            if ($image) {
                                $imagePath = $image->image_path;
                                break;
                            }
                        }
                    }
                }

                if (!$imagePath) {
                    $imagePath = optional($product->images->first())->image_path ?? 'fallback.png';
                }

                // var_dump($price);

                return (object)[
                    'id' => $item->id,
                    'product_id' => $product->id,
                    'variant_id' => $variant?->id,
                    'name' => $product->name,
                    'description' => $product->short_description, // 🔥 NEW
                    'image' => $imagePath,
                    'price' => $price,
                    'qty' => $item->quantity,
                    'attributes' => $attributes, // 🔥 NEW
                    'product' => $product,
                    'variant' => $variant,
                ];
            });

        $total = $cartItems->sum(fn($item) => $item->price * $item->qty);
        // var_dump($total);exit;

        $addresses = ShippingAddress::where('user_id', $userId)
            ->orderByDesc('is_default')
            ->get();



        // $originalTotal = 0;
        // $finalTotal = 0;
        // foreach ($cartItems as $item) {
        //     $original = $item->variant?->compare_price ?? $item->product->price;
        //     $final = $item->price;
        //     $originalTotal += $original * $item->qty;
        //     $finalTotal += $final * $item->qty;
        // }
        // $discount = $originalTotal - $finalTotal;
        // var_dump($originalTotal);
        // var_dump($finalTotal);
        // var_dump($discount);

        // exit;




        return view('website.cart', compact('cartItems', 'total', 'addresses'));
    }

    public function update(Request $request)
    {
        $cart = Cart::where('id', $request->cart_id)
            ->where('user_id', auth('customer')->id())
            ->firstOrFail();

        $newQty = $cart->quantity + $request->delta;

        if ($newQty < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid quantity'
            ]);
        }

        $stock = $cart->variant?->stock ?? $cart->product->stock;

        if ($newQty > $stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stock limit exceeded'
            ]);
        }

        $cart->update(['quantity' => $newQty]);

        // 🔥 CALCULATIONS
        $price = $cart->variant?->price ?? $cart->product->price;
        $itemTotal = $price * $newQty;

        $cartSummary = $this->getCartSummary(auth('customer')->id());

        return response()->json([
            'success' => true,
            'item' => [
                'id' => $cart->id,
                'qty' => $newQty,
                'price' => $price,
                'total' => $itemTotal,
            ],
            'cart' => $cartSummary
        ]);
    }

    public function remove(Request $request)
    {
        Cart::where('id', $request->cart_id)
            ->where('user_id', auth('customer')->id())
            ->delete();

        $cartSummary = $this->getCartSummary(auth('customer')->id());

        return response()->json([
            'success' => true,
            'cart' => $cartSummary
        ]);
    }

    private function getCartSummary($userId)
    {
        $cartItems = Cart::with(['product', 'variant'])
            ->where('user_id', $userId)
            ->where('is_ordered', false)
            ->get();

        $subtotal = 0;
        $count = 0;

        foreach ($cartItems as $item) {
            $price = $item->variant?->price ?? $item->product->price;
            $subtotal += $price * $item->quantity;
            $count += $item->quantity;
        }

        $shipping = 0;
        $tax = 0;
        $grandTotal = $subtotal + $shipping + $tax;

        return [
            'subtotal' => $subtotal,
            'grand_total' => $grandTotal,
            'count' => $count
        ];
    }
}
