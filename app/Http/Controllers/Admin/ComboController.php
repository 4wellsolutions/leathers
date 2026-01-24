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
        return view('admin.combos.create');
    }

    public function searchProducts(Request $request)
    {
        $search = $request->get('q');
        $products = Product::where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->with([
                'variants.color',
                'variants' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->take(20)
            ->get();

        return response()->json($products);
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
            'variants' => 'required|array|min:2',
            'variants.*' => 'exists:product_variants,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        // Auto-generate slug from name if not provided or if slug equals name
        if (empty($validated['slug']) || $validated['slug'] === $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Debug logging
        \Log::info('Combo Store - Name: ' . $validated['name']);
        \Log::info('Combo Store - Slug: ' . $validated['slug']);

        $combo = Combo::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($validated['variants'] as $variantId) {
            $quantity = $validated['quantities'][$variantId] ?? 1;
            $variant = \App\Models\ProductVariant::find($variantId);
            $combo->items()->create([
                'product_id' => $variant->product_id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('admin.combos.index')->with('success', 'Combo created successfully');
    }

    public function edit(Combo $combo)
    {
        // Load the combo with its items, variants, and products
        $combo->load(['items.variant.color', 'items.product.variants.color']);

        // We'll prepare a list of initial products to populate the UI
        $initialProducts = collect();

        foreach ($combo->items as $item) {
            $product = $item->variant ? $item->variant->product : $item->product;

            // Ensure we haven't already added this product
            if (!$initialProducts->contains('id', $product->id)) {
                // Load its variants fully if not already
                if (!$product->relationLoaded('variants')) {
                    $product->load([
                        'variants.color',
                        'variants' => function ($q) {
                            $q->where('is_active', true);
                        }
                    ]);
                }
                $initialProducts->push($product);
            }
        }

        return view('admin.combos.edit', compact('combo', 'initialProducts'));
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
            'variants' => 'required|array|min:2',
            'variants.*' => 'exists:product_variants,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        // Auto-generate slug from name if not provided or if slug equals name
        if (empty($validated['slug']) || $validated['slug'] === $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

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
        foreach ($validated['variants'] as $variantId) {
            $quantity = $validated['quantities'][$variantId] ?? 1;
            $variant = \App\Models\ProductVariant::find($variantId);
            $combo->items()->create([
                'product_id' => $variant->product_id,
                'product_variant_id' => $variantId,
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
