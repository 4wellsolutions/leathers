<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::latest()->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $products = \App\Models\Product::where('is_active', true)->get();
        return view('admin.sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sales',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        } else {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['slug']);
        }

        $sale = Sale::create($validated);

        if (!empty($request->products)) {
            \App\Models\Product::whereIn('id', $request->products)->update(['sale_id' => $sale->id]);
        }

        return redirect()->route('admin.sales.index')->with('success', 'Sale created successfully');
    }

    public function edit(Sale $sale)
    {
        $products = \App\Models\Product::where('is_active', true)->get();
        return view('admin.sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sales,slug,' . $sale->id,
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        } else {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['slug']);
        }

        $sale->update($validated);

        // Reset all products currently associated with this sale
        \App\Models\Product::where('sale_id', $sale->id)->update(['sale_id' => null]);

        // Assign selected products
        if (!empty($request->products)) {
            \App\Models\Product::whereIn('id', $request->products)->update(['sale_id' => $sale->id]);
        }

        return redirect()->route('admin.sales.index')->with('success', 'Sale updated successfully');
    }

    public function destroy(Sale $sale)
    {
        // Unassign products before deleting
        \App\Models\Product::where('sale_id', $sale->id)->update(['sale_id' => null]);

        $sale->delete();
        return redirect()->route('admin.sales.index')->with('success', 'Sale deleted successfully');
    }
}
