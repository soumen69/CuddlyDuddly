<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sellers;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'user');
        $search = trim($request->get('q'));

        $model = $this->resolveModel($type);

        $query = $model::onlyTrashed()->latest();

        if ($search) {
            $this->applySearch($query, $type, $search);
        }

        $items = $query->paginate(10)->withQueryString();

        $counts = [
            'users' => User::onlyTrashed()->count(),
            'sellers' => Sellers::onlyTrashed()->count(),
        ];

        return view('admin.trash.index', compact('items', 'type', 'search', 'counts'));
    }

    private function applySearch($query, $type, $search)
    {
        $columns = $this->searchableColumns($type);

        $query->where(function ($q) use ($columns, $search) {
            foreach ($columns as $col) {
                $q->orWhere($col, 'like', "%{$search}%");
            }
        });
    }

    private function searchableColumns($type)
    {
        return match ($type) {

            'user' => ['name', 'email'],
            'seller' => ['name', 'email'],

            // future ready 👇
            'product' => ['title', 'sku'],
            'order' => ['order_number'],

            default => ['id'],
        };
    }

    public function restore($type, $id)
    {
        $model = $this->resolveModel($type);
        $model::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', ucfirst($type) . ' restored');
    }

    public function delete($type, $id)
    {
        $model = $this->resolveModel($type);
        $model::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', ucfirst($type) . ' permanently deleted');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'type' => 'required|in:user,seller',
            'action' => 'required|in:restore,delete',
            'ids' => 'required|array|min:1'
        ]);

        $model = $this->resolveModel($request->type);
        $items = $model::onlyTrashed()->whereIn('id', $request->ids)->get();

        foreach ($items as $item) {
            $request->action === 'restore'
                ? $item->restore()
                : $item->forceDelete();
        }

        return back()->with('success', 'Bulk action completed');
    }

    private function resolveModel($type)
    {
        return match ($type) {
            'user' => User::class,
            'seller' => Sellers::class,
            default => abort(404),
        };
    }
}
