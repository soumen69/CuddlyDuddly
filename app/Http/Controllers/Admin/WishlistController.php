<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $query = Wishlist::with(['user', 'product.primaryImage'])->latest();

        if ($search = trim($request->input('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) =>
                $u->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%"))
                    ->orWhereHas('product', fn($p) =>
                    $p->where('name', 'like', "%$search%"));
            });
        }

        $wishlists = $query->get()->groupBy('user_id');
        $total = $wishlists->flatten()->count();

        return view('admin.wishlists.index', compact('wishlists', 'total'));
    }

    public function destroy($id)
    {
        Wishlist::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function show(Request $request, $userId)
    {
        $wishlists = Wishlist::with(['product.primaryImage'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            if ($wishlists->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No wishlist items found.']);
            }

            $wishlistData = $wishlists->map(function ($item) {
                return [
                    'id'       => $item->id,
                    'name'     => $item->product->name ?? 'Unknown Product',
                    'price'    => number_format($item->product->price ?? 0, 2),
                    'in_stock' => ($item->product->stock ?? 0) > 0,
                    'image'    => $item->product && $item->product->primaryImage
                        ? asset('storage/' . $item->product->primaryImage->image_path)
                        : asset('images/no-image.png'),
                    'date'     => $item->created_at->format('d M Y'),
                ];
            });

            return response()->json(['success' => true, 'wishlist' => $wishlistData]);
        }

        // If request is NOT JSON (normal page visit)
        $user = $wishlists->first()?->user;
        $total = $wishlists->count();

        return view('admin.wishlists.show', compact('wishlists', 'user', 'total'));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            Wishlist::whereIn('id', $ids)->delete();
        }
        return response()->json(['success' => true]);
    }
}
