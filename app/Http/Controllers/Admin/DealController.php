<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::with('products')->paginate(10);
        return view('admin.deals.index', compact('deals'));
    }

    public function create()
    {
        return view('admin.deals.create');
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
            'slug' => 'nullable|string|max:255|unique:deals',
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
        $name = $validated['name'];
        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($name);

        // Debug logging
        \Log::info('Deal Store - Name: ' . $validated['name']);
        \Log::info('Deal Store - Slug: ' . $slug);

        $deal = Deal::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($validated['variants'] as $variantId) {
            $quantity = $validated['quantities'][$variantId] ?? 1;
            $variant = \App\Models\ProductVariant::find($variantId);
            $deal->items()->create([
                'product_id' => $variant->product_id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('admin.deals.index')->with('success', 'Deal created successfully');
    }

    public function edit(Deal $deal)
    {
        // Load the deal with its items, variants, and products
        $deal->load(['items.variant.color', 'items.product.variants.color']);

        // We'll prepare a list of initial products to populate the UI
        $initialProducts = collect();

        foreach ($deal->items as $item) {
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

        return view('admin.deals.edit', compact('deal', 'initialProducts'));
    }

    public function update(Request $request, Deal $deal)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:deals,slug,' . $deal->id,
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

        $name = $validated['name'];
        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($name);

        $deal->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active'),
        ]);

        // Sync items
        $deal->items()->delete();
        foreach ($validated['variants'] as $variantId) {
            $quantity = $validated['quantities'][$variantId] ?? 1;
            $variant = \App\Models\ProductVariant::find($variantId);
            $deal->items()->create([
                'product_id' => $variant->product_id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('admin.deals.index')->with('success', 'Deal updated successfully');
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->route('admin.deals.index')->with('success', 'Deal deleted successfully');
    }
}
