<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Sellers;
use App\Models\ProductImage;
use App\Models\MasterCategorySection;
use App\Models\ProductCategorySection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\ProductImageService;

class SellerProductController extends Controller
{
    public function index(Request $request, Sellers $seller)
    {
        // Security check: Ensure the logged-in seller is accessing their own slug
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $activeTab = $request->get('active_tab', 'products');

        $products = Products::where('seller_id', $seller->id)
            ->when($activeTab == 'draft', function ($query) {
                $query->where('status', 'draft');
            }, function ($query) {
                $query->where('status', '!=', 'draft');
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('seller.products.index', compact('products', 'seller', 'activeTab'));
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

        return view('seller.products.create', compact('categoryTree', 'id', 'seller'));
    }


    public function store(Request $request, ProductImageService $imageService, Sellers $seller)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $id = $seller->id;

        $validated = $request->validate([
            'master_category_section_id' => 'required|array|min:1',
            'master_category_section_id.*' => 'exists:master_category_sections,id',

            'name' => 'required|string|max:255|regex:/^[A-Za-z0-9 .,()\-%&]+$/',
            'price' => 'required|numeric|min:100',
            'stock' => 'required|integer|min:10',

            'auto_sku' => 'nullable|boolean',
            'sku' => 'nullable|string|unique:products,sku',

            'short_description' => 'required|string',
            'description' => 'required|string', //Product Information
            'brand_info' => 'required|string',  //Brand Information
            'youtube_url' => 'nullable|string',
            'cancellation_policy' => 'nullable|string',

            'images' => 'required|array|min:5|max:5',
            'images.*' => 'required|image|max:20480',
        ], [

            //Name
            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must be a string.',
            'name.max' => 'Product name cannot exceed 255 characters.',
            'name.regex' => 'Product name can only contain letters, numbers, spaces, dot, comma, hyphen and brackets.',

            // Price
            'price.required' => 'Product price is required.',
            'price.numeric' => 'Product price must be a number.',
            'price.min' => 'Product price must be at least 100.',
            'price.regex' => 'Product price must be a valid number.',

            //Brand Info
            'brand_info.required' => 'Brand information is required.',
            'brand_info.string' => 'Brand information must be a string.',

            //Short Description
            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a string.',

            //Stock
            'stock.required' => 'Stock is required.',
            'stock.regex' => 'Stock must contain only numbers.',
            'stock.integer' => 'Stock must be an integer.',
            'stock.min' => 'Stock must be at least 10.',


            'images.*.max' => 'Each image must be less than 20MB.',
            'images.required' => 'Upload at least 5 product images.',
        ]);

        DB::beginTransaction();

        try {

            $sellerId = $id;

            // Step 1: Create product WITHOUT SKU first
            $product = Products::create([
                'seller_id' => $sellerId,
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']) . '-' . uniqid(),

                'description' => $validated['description'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'brand_info' => $validated['brand_info'] ?? null,
                'youtube_url' => $validated['youtube_url'] ?? null,
                'cancellation_policy' => $validated['cancellation_policy'] ?? null,

                'price' => $validated['price'],
                'stock' => $validated['stock'],

                'auto_sku' => $request->auto_sku ? 1 : 0,
                'sku' => null,

                'is_approved' => 0, // default pending
                'status' => $request->action === 'draft' ? '0' : '1',

            ]);

            // Step 2: Generate SKU
            if ($request->auto_sku) {
                // Professional SKU: SLR{sellerId}-{productId padded}
                $sku = 'SLR' . $sellerId . '-' . str_pad($product->id, 8, '0', STR_PAD_LEFT);
            } else {
                $sku = $validated['sku'];
            }

            // Step 3: Update SKU
            $product->update([
                'sku' => $sku
            ]);

            // Step 4: Store product images
            if ($request->hasFile('images')) {
                $isFirst = true;
                $paths = [];
                foreach ($request->file('images') as $image) {
                    $filename = $imageService->process($image);
                    $path = $filename;

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $isFirst ? 1 : 0,
                    ]);

                    $isFirst = false;
                }
            }

            // Step 5: Attach categories
            foreach ($validated['master_category_section_id'] as $categoryId) {
                ProductCategorySection::create([
                    'product_id' => $product->id,
                    'master_category_section_id' => $categoryId,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('seller.products.index', $seller->slug)
                ->with('success', 'Product added successfully and pending for approval.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the product. ' . $e->getMessage());
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
        $activeTab = $request->get('active_tab', 'products');

        $products = Products::with('categorySections.category')
            ->where('seller_id', $seller->id)
            ->when($activeTab == 'draft', function ($query) {
                $query->where('status', 'draft');
            }, function ($query) {
                $query->where('status', '!=', 'draft');
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        // ->orWhere('sku', 'LIKE', "%{$search}%")
                        ->orWhere('price', 'LIKE', "%{$search}%")
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
            return view('seller.products.partials.table-container', compact('products', 'seller'))->render();
        }

        return view('seller.products.index', compact('products', 'seller', 'activeTab'));
    }



    public function edit(Sellers $seller, $productId)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $id = $seller->id;

        $product = Products::with('images')
            ->where('seller_id', $id)
            ->findOrFail($productId);

        $categoryTree = MasterCategorySection::with(['masterCategory', 'sectionType', 'category'])->get();

        return view('seller.products.create', compact('product', 'id', 'categoryTree', 'seller'));
    }


    public function update(Request $request, Sellers $seller, $id)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $sellerId = $seller->id;

        $product = Products::where('seller_id', $sellerId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:100',
            'stock' => 'required|integer|min:10',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'brand_info' => 'required|string',
            'youtube_url' => 'nullable|string',
            'cancellation_policy' => 'nullable|string',
            'master_category_section_id' => 'required|array',
            'master_category_section_id.*' => 'exists:master_category_sections,id',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:512',
        ]);

        DB::beginTransaction();

        try {
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'brand_info' => $request->brand_info,
                'youtube_url' => $request->youtube_url,
                'cancellation_policy' => $request->cancellation_policy,
                'sku' => $request->has('auto_sku') ? $product->sku : $request->sku,
                'auto_sku' => $request->has('auto_sku') ? 1 : 0,
            ]);

            // Update categories
            $product->categorySections()->delete();
            foreach ($request->master_category_section_id as $sectionId) {
                ProductCategorySection::create([
                    'product_id' => $product->id,
                    'master_category_section_id' => $sectionId,
                ]);
            }

            // Handle existing images
            $existingImageIds = $request->input('existing_images', []);
            $product->images()->whereNotIn('id', $existingImageIds)->delete();

            // Handle new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => 0,
                    ]);
                }
            }

            // Ensure we have exactly one primary image
            $this->ensurePrimaryImage($product);

            DB::commit();

            return redirect()->route('seller.products.index', $seller->slug)->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
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


    public function ckeditorImageUpload(Request $request, Sellers $seller)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:3048'
        ]);

        $image = $request->file('upload');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/ckeditor'), $filename);

        return response()->json([
            'uploaded' => 1,
            'url' => '/uploads/ckeditor/' . $filename,
        ]);
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


    // public function show(Sellers $seller, $id)
    // {
    //     // Security check
    //     if (Auth::guard('seller')->id() !== $seller->id) {
    //         abort(403);
    //     }

    //     $product = Products::with([
    //         'images',
    //         // 'seller',
    //         'categorySections.masterCategory',
    //         'categorySections.sectionType',
    //         'categorySections.category'
    //     ])
    //         ->where('seller_id', $seller->id)
    //         ->findOrFail($id);

    //     return view('seller.products.show', compact('product', 'seller'));
    // }

}
