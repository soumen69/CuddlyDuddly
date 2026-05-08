<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Attribute;
use App\Models\ProductCategoryAttribute;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('attributes.attribute')
            ->orderByDesc('id')
            ->paginate(5);

        return view('admin.productsCategories.index', compact('categories'));
    }

    public function create()
    {
        $categories = ProductCategory::with('attributes.attribute.values')->get();
        $attributes = Attribute::with('values')->get();

        return view('admin.productsCategories.create', compact('categories', 'attributes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'sub_categories' => 'nullable|array',
            'sub_categories.*' => 'nullable|string|max:255',
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.input_type' => 'required|in:select,multi-select,boolean',
            'attributes.*.is_filterable' => 'nullable|boolean',
            'attributes.*.is_variant' => 'nullable|boolean',
            'attributes.*.is_visual' => 'nullable|boolean',
            'attributes.*.values' => 'nullable|array',
            'attributes.*.values.*' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {

            /*
        |--------------------------------------------------------------------------
        | 1️⃣ Create Product Category
        |--------------------------------------------------------------------------
        */

            $category = ProductCategory::create([
                'name'   => trim($validated['category_name']),
                'slug'   => Str::slug($validated['category_name']) . '-' . uniqid(),
                'status' => $validated['status'],
            ]);

            /*
        |--------------------------------------------------------------------------
        | 2️⃣ Create Sub Categories (Cleaned + Unique)
        |--------------------------------------------------------------------------
        */

            if (!empty($validated['sub_categories'])) {

                $uniqueSubs = collect($validated['sub_categories'])
                    ->filter()
                    ->map(fn($sub) => trim($sub))
                    ->unique()
                    ->values();

                foreach ($uniqueSubs as $sub) {
                    ProductSubCategory::create([
                        'product_categories_id' => $category->id,
                        'name'   => $sub,
                        'slug'   => Str::slug($sub) . '-' . uniqid(),
                        'status' => 1,
                    ]);
                }
            }

            /*
        |--------------------------------------------------------------------------
        | 3️⃣ Create Attributes + Values + Mapping
        |--------------------------------------------------------------------------
        */

            if (!empty($validated['attributes'])) {

                foreach ($validated['attributes'] as $attrData) {

                    $attrName = trim($attrData['name']);

                    if (!$attrName) continue;

                    $attribute = Attribute::create([
                        'name'          => $attrName,
                        'slug'          => Str::slug($attrName) . '-' . uniqid(),
                        'input_type'    => $attrData['input_type'],
                        'is_filterable' => !empty($attrData['is_filterable']) ? 1 : 0,
                        'is_variant'    => !empty($attrData['is_variant']) ? 1 : 0,
                        'is_visual'     => !empty($attrData['is_visual']) ? 1 : 0,
                        'status'        => 1,
                    ]);

                    /*
                |--------------------------------------------------------------------------
                | Create Attribute Values (if allowed)
                |--------------------------------------------------------------------------
                */

                    if (
                        in_array($attrData['input_type'], ['select', 'multi-select']) &&
                        !empty($attrData['values'])
                    ) {

                        $uniqueValues = collect($attrData['values'])
                            ->filter()
                            ->map(fn($v) => trim($v))
                            ->unique()
                            ->values();

                        foreach ($uniqueValues as $value) {
                            AttributeValue::create([
                                'attribute_id' => $attribute->id,
                                'value'        => $value,
                                'slug'         => Str::slug($value) . '-' . uniqid(),
                                'sort_order'   => 0,
                            ]);
                        }
                    }

                    /*
                |--------------------------------------------------------------------------
                | Map Attribute to Product Category
                |--------------------------------------------------------------------------
                */

                    ProductCategoryAttribute::create([
                        'product_categories_id' => $category->id,
                        'attribute_id'          => $attribute->id,
                        'is_required'           => 0,
                        'is_filterable'         => !empty($attrData['is_filterable']) ? 1 : 0,
                        'sort_order'            => 0,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category created successfully.');
    }

    public function edit($id)
    {
        $category = ProductCategory::with([
            'subCategories',
            'attributes.attribute.values'
        ])->findOrFail($id);

        $attributes = $category->attributes->map(function ($map) {
            return [
                'uid' => $map->attribute->id,
                'name' => $map->attribute->name,
                'type' => $map->attribute->input_type,
                'filter' => $map->attribute->is_filterable,
                'variant' => $map->attribute->is_variant,
                'visual' => $map->attribute->is_visual,
                'values' => $map->attribute->values->pluck('value')->values()->toArray(),
            ];
        });

        return view('admin.productsCategories.edit', [
            'category' => $category,
            'attributesData' => $attributes
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'sub_categories' => 'nullable|array',
            'sub_categories.*' => 'nullable|string|max:255',

            'attributes' => 'nullable|array',
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.input_type' => 'required|in:select,multi-select,boolean',
            'attributes.*.is_filterable' => 'nullable|boolean',
            'attributes.*.is_variant' => 'nullable|boolean',
            'attributes.*.is_visual' => 'nullable|boolean',
            'attributes.*.values' => 'nullable|array',
            'attributes.*.values.*' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $id) {
            $category = ProductCategory::findOrFail($id);
            $category->update([
                'name'   => trim($validated['category_name']),
                'slug'   => Str::slug($validated['category_name']) . '-' . uniqid(),
                'status' => $validated['status'],
            ]);

            $attributeIds = ProductCategoryAttribute::where('product_categories_id', $category->id)
                ->pluck('attribute_id');
            AttributeValue::whereIn('attribute_id', $attributeIds)->delete();
            Attribute::whereIn('id', $attributeIds)->delete();
            ProductCategoryAttribute::where('product_categories_id', $category->id)->delete();
            ProductSubCategory::where('product_categories_id', $category->id)->delete();

            if (!empty($validated['sub_categories'])) {
                $uniqueSubs = collect($validated['sub_categories'])
                    ->filter()
                    ->map(fn($sub) => trim($sub))
                    ->unique()
                    ->values();
                foreach ($uniqueSubs as $sub) {
                    ProductSubCategory::create([
                        'product_categories_id' => $category->id,
                        'name'   => $sub,
                        'slug'   => Str::slug($sub) . '-' . uniqid(),
                        'status' => 1,
                    ]);
                }
            }

            if (!empty($validated['attributes'])) {
                foreach ($validated['attributes'] as $attrData) {
                    $attrName = trim($attrData['name']);
                    if (!$attrName) continue;
                    $attribute = Attribute::create([
                        'name'          => $attrName,
                        'slug'          => Str::slug($attrName) . '-' . uniqid(),
                        'input_type'    => $attrData['input_type'],
                        'is_filterable' => !empty($attrData['is_filterable']) ? 1 : 0,
                        'is_variant'    => !empty($attrData['is_variant']) ? 1 : 0,
                        'is_visual'    => !empty($attrData['is_visual']) ? 1 : 0,
                        'status'        => 1,
                    ]);

                    if (!empty($attrData['values'])) {
                        $uniqueValues = collect($attrData['values'])
                            ->filter()
                            ->map(fn($v) => trim($v))
                            ->unique()
                            ->values();
                        foreach ($uniqueValues as $value) {
                            AttributeValue::create([
                                'attribute_id' => $attribute->id,
                                'value'        => $value,
                                'slug'         => Str::slug($value) . '-' . uniqid(),
                                'sort_order'   => 0,
                            ]);
                        }
                    }

                    ProductCategoryAttribute::create([
                        'product_categories_id' => $category->id,
                        'attribute_id'          => $attribute->id,
                        'is_required'           => 0,
                        'is_filterable'         => !empty($attrData['is_filterable']) ? 1 : 0,
                        'sort_order'            => 0,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category updated successfully.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $category = ProductCategory::findOrFail($id);

            /*
        |--------------------------------------------------------------------------
        | Get Attribute IDs linked with this Category
        |--------------------------------------------------------------------------
        */

            $attributeIds = ProductCategoryAttribute::where(
                'product_categories_id',
                $category->id
            )->pluck('attribute_id');

            /*
        |--------------------------------------------------------------------------
        | Delete Attribute Values
        |--------------------------------------------------------------------------
        */

            if ($attributeIds->isNotEmpty()) {

                AttributeValue::whereIn('attribute_id', $attributeIds)->delete();
            }

            /*
        |--------------------------------------------------------------------------
        | Delete Attributes
        |--------------------------------------------------------------------------
        */

            Attribute::whereIn('id', $attributeIds)->delete();

            /*
        |--------------------------------------------------------------------------
        | Delete Category Attribute Mapping
        |--------------------------------------------------------------------------
        */

            ProductCategoryAttribute::where(
                'product_categories_id',
                $category->id
            )->delete();

            /*
        |--------------------------------------------------------------------------
        | Delete Sub Categories
        |--------------------------------------------------------------------------
        */

            ProductSubCategory::where(
                'product_categories_id',
                $category->id
            )->delete();

            /*
        |--------------------------------------------------------------------------
        | Finally Delete Category
        |--------------------------------------------------------------------------
        */

            $category->delete();
        });

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }

    public function show($id)
    {
        $category = ProductCategory::with([
            'subCategories',
            'attributes.attribute.values'
        ])->findOrFail($id);

        return view('admin.productsCategories.show', compact('category'));
    }
}
