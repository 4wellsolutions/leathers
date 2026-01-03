<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComboController extends Controller
{
    public function index()
    {
        $combos = Combo::with('products')->paginate(10);
        return view('admin.combos.index', compact('combos'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.combos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:combos',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'products' => 'required|array|min:2',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $combo = Combo::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($validated['products'] as $productId) {
            $quantity = $validated['quantities'][$productId] ?? 1;
            $combo->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('admin.combos.index')->with('success', 'Combo created successfully');
    }

    public function edit(Combo $combo)
    {
        $products = Product::where('is_active', true)->get();
        $combo->load('items');
        return view('admin.combos.edit', compact('combo', 'products'));
    }

    public function update(Request $request, Combo $combo)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:combos,slug,' . $combo->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'products' => 'required|array|min:2',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $combo->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active'),
        ]);

        // Sync items
        $combo->items()->delete();
        foreach ($validated['products'] as $productId) {
            $quantity = $validated['quantities'][$productId] ?? 1;
            $combo->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('admin.combos.index')->with('success', 'Combo updated successfully');
    }

    public function destroy(Combo $combo)
    {
        $combo->delete();
        return redirect()->route('admin.combos.index')->with('success', 'Combo deleted successfully');
    }
}
