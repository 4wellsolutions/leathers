<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::latest()->paginate(10);
        return view('admin.deals.index', compact('deals'));
    }

    public function create()
    {
        return view('admin.deals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:deals',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        Deal::create($validated);

        return redirect()->route('admin.deals.index')->with('success', 'Deal created successfully');
    }

    public function edit(Deal $deal)
    {
        return view('admin.deals.edit', compact('deal'));
    }

    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:deals,slug,' . $deal->id,
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        $deal->update($validated);

        return redirect()->route('admin.deals.index')->with('success', 'Deal updated successfully');
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->route('admin.deals.index')->with('success', 'Deal deleted successfully');
    }
}
