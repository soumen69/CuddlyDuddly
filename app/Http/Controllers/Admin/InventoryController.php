<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\Products;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $inventories = Inventory::with(['product.primaryImage', 'seller'])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                })->orWhere('sku', 'like', "%{$search}%");
            })
            ->when($request->seller_id, function ($query, $sellerId) {
                $query->where('seller_id', $sellerId);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->paginate(20);

        $sellers = Sellers::orderBy('name')->get(['id', 'name', 'contact_person']);

        return view('admin.inventory.index', compact('inventories', 'sellers'));
    }

    public function create()
    {
        $products = Products::all();
        $sellers = Sellers::all();
        return view('admin.inventory.create', compact('products', 'sellers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'seller_id' => 'required|exists:sellers,id',
            'sku'        => 'nullable|unique:inventories,sku',
            'quantity'   => 'required|integer|min:0',
            'price'      => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)      // send validation errors
                ->withInput();                // keep old input values
        }

        $inventory = Inventory::create($request->all());

        // Log the inventory creation
        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'action'       => 'added',
            'quantity'     => $inventory->quantity,
            'remarks'      => 'Initial stock added',
            'created_by'   => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory created successfully.');
    }


    public function show(Inventory $inventory)
    {
        $products = Products::all();
        return view('admin.inventory.show', compact('inventory', 'products'));
    }


    public function edit(Inventory $inventory)
    {
        $products = Products::all();
        $sellers = Sellers::all();
        return view('admin.inventory.edit', compact('inventory', 'products', 'sellers'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'seller_id' => 'required|exists:sellers,id',
            'sku' => 'required|unique:inventories,sku,' . $inventory->id,
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        // Check for quantity change to log
        if ($request->quantity != $inventory->quantity) {
            $diff = $request->quantity - $inventory->quantity;
            $action = $diff > 0 ? 'added' : 'removed';

            InventoryLog::create([
                'inventory_id' => $inventory->id,
                'action' => $action,
                'quantity' => abs($diff),
                'remarks' => 'Stock updated',
                'created_by' => Auth::guard('admin')->id(),
            ]);
        }

        $inventory->update($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'action' => 'removed',
            'quantity' => $inventory->quantity,
            'remarks' => 'Inventory deleted',
            'created_by' => Auth::guard('admin')->id(),
        ]);

        $inventory->delete();

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory deleted successfully.');
    }

    public function reserveStock(Inventory $inventory, int $quantity)
    {
        if ($quantity > $inventory->quantity - $inventory->reserved_quantity) {
            return response()->json(['error' => 'Not enough stock available'], 400);
        }

        $inventory->increment('reserved_quantity', $quantity);

        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'action' => 'reserved',
            'quantity' => $quantity,
            'remarks' => 'Stock reserved for order',
            'created_by' => Auth::guard('admin')->id(),
        ]);

        return response()->json(['success' => 'Stock reserved successfully']);
    }
    public function releaseStock(Inventory $inventory, int $quantity)
    {
        if ($quantity > $inventory->reserved_quantity) {
            return response()->json(['error' => 'Reserved stock insufficient'], 400);
        }

        $inventory->decrement('reserved_quantity', $quantity);

        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'action' => 'released',
            'quantity' => $quantity,
            'remarks' => 'Reserved stock released',
            'created_by' => Auth::guard('admin')->id(),
        ]);

        return response()->json(['success' => 'Reserved stock released successfully']);
    }
    public function adjustStock(Request $request, Inventory $inventory)
    {
        $request->validate([
            'action' => 'required|in:added,removed,reserve,release',
            'quantity' => 'nullable|integer|min:0',
            'remarks' => 'nullable|string|max:500',
        ]);

        $action = $request->action;
        $quantity = intval($request->quantity ?? 0);
        $userId = Auth::guard('admin')->id();

        // Map action to log enum
        $logAction = match ($action) {
            'reserve' => 'reserved',
            'release' => 'unreserved',
            default => $action,
        };

        // Add/Remove stock
        if (in_array($action, ['added', 'removed'])) {
            if ($action === 'added') $inventory->increment('quantity', $quantity);
            else {
                $available = $inventory->quantity - $inventory->reserved_quantity;
                if ($quantity > $available) {
                    return response()->json(['error' => "Cannot remove more than available stock ($available)"], 400);
                }
                $inventory->decrement('quantity', $quantity);
            }
        }

        // Reserve/Release
        if (in_array($action, ['reserve', 'release'])) {
            if ($action === 'reserve') {
                $available = $inventory->quantity - $inventory->reserved_quantity;
                if ($quantity > $available) {
                    return response()->json(['error' => "Cannot reserve more than available ($available)"], 400);
                }
                $inventory->increment('reserved_quantity', $quantity);
            } else {
                if ($quantity > $inventory->reserved_quantity) {
                    return response()->json(['error' => "Cannot release more than reserved ($inventory->reserved_quantity)"], 400);
                }
                $inventory->decrement('reserved_quantity', $quantity);
            }
        }

        InventoryLog::create([
            'inventory_id' => $inventory->id,
            'action' => $logAction,
            'quantity' => $quantity,
            'remarks' => $request->remarks ?? 'Stock adjustment',
            'created_by' => $userId,
        ]);

        return response()->json(['success' => 'Inventory updated successfully']);
    }
}
