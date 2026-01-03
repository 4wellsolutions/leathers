<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    public function index()
    {
        $shippingRules = ShippingRule::orderBy('priority')->get();
        return view('admin.shipping-rules.index', compact('shippingRules'));
    }

    public function create()
    {
        return view('admin.shipping-rules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'is_active' => 'boolean',
            'priority' => 'required|integer|min:0',
        ]);

        ShippingRule::create($validated);

        return redirect()->route('admin.shipping-rules.index')
            ->with('success', 'Shipping rule created successfully');
    }

    public function edit(ShippingRule $shippingRule)
    {
        return view('admin.shipping-rules.edit', compact('shippingRule'));
    }

    public function update(Request $request, ShippingRule $shippingRule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'is_active' => 'boolean',
            'priority' => 'required|integer|min:0',
        ]);

        $shippingRule->update($validated);

        return redirect()->route('admin.shipping-rules.index')
            ->with('success', 'Shipping rule updated successfully');
    }

    public function destroy(ShippingRule $shippingRule)
    {
        $shippingRule->delete();

        return redirect()->route('admin.shipping-rules.index')
            ->with('success', 'Shipping rule deleted successfully');
    }
}
