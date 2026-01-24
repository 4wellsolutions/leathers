<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public function index()
    {
        $combos = Combo::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->with(['items.product', 'items.variant'])
            ->get();

        return view('combos.index', compact('combos'));
    }

    public function show($slug)
    {
        $combo = Combo::where('slug', $slug)
            ->where('is_active', true)
            ->with(['items.product', 'items.variant.color'])
            ->firstOrFail();

        if (!$combo->isValid()) {
            abort(404);
        }

        // Get all reviews from products in this combo
        $productIds = $combo->items->pluck('product_id')->unique();
        $allReviews = \App\Models\Review::whereIn('product_id', $productIds)
            ->where('is_approved', true)
            ->with(['user', 'product'])
            ->latest()
            ->get();

        // Get related combos (exclude current combo)
        $relatedCombos = Combo::where('id', '!=', $combo->id)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->with(['items.product', 'items.variant'])
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('combos.show', compact('combo', 'relatedCombos', 'allReviews'));
    }
}
