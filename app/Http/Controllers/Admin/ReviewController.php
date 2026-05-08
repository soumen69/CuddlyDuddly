<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use App\Models\Products;
use App\Models\User;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with([
            'product.primaryImage',
            'customer'
        ]);

        // 🔍 Filter by product name
        if ($request->filled('product')) {
            $product = trim($request->product);

            $query->whereHas('product', function ($q) use ($product) {
                $q->where('name', 'like', "%{$product}%");
            });
        }

        // ⭐ Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', (int) $request->rating);
        }

        // 🧭 Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating_high':
                $query->orderBy('rating', 'desc');
                break;
            case 'rating_low':
                $query->orderBy('rating', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // 🚀 Fetch reviews
        $reviews = $query->paginate(10)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }


    // Show single review
    public function show(Review $review)
    {
        $review->load(['products', 'customers']);
        return view('admin.reviews.show', compact('review'));
    }

    // Show create form
    public function create()
    {
        $products = Products::all();
        $customers = User::all();
        return view('admin.reviews.create', compact('products', 'customers'));
    }

    // Store new review
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Review::create($request->all());

        return redirect()->route('admin.reviews.index')->with('success', 'Review added successfully.');
    }

    // Show edit form
    public function edit(Review $review)
    {
        $products = Products::all();
        $customers = User::all();
        return view('admin.reviews.edit', compact('review', 'products', 'customers'));
    }

    // Update review
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($request->all());

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully.');
    }

    // Delete review
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }

    // Bulk delete reviews
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:reviews,id',
        ]);

        Review::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected reviews deleted successfully.',
        ]);
    }


    public function CustomerReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        Review::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'user_id' => auth('customer')->id()
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment
            ]
        );

        return back()->with('success', 'Review submitted');
    }
}
