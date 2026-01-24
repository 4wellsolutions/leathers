<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::where('is_active', true)
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

        return view('deals.index', compact('deals'));
    }

    public function show($slug)
    {
        $deal = Deal::where('slug', $slug)
            ->where('is_active', true)
            ->with(['items.product', 'items.variant.color'])
            ->firstOrFail();

        if (!$deal->isValid()) {
            abort(404);
        }

        // Get all reviews from products in this deal
        $productIds = $deal->items->pluck('product_id')->unique();
        $allReviews = \App\Models\Review::whereIn('product_id', $productIds)
            ->where('is_approved', true)
            ->with(['user', 'product'])
            ->latest()
            ->get();

        // Get related deals (exclude current deal)
        $relatedDeals = Deal::where('id', '!=', $deal->id)
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

        return view('deals.show', compact('deal', 'relatedDeals', 'allReviews'));
    }
}
