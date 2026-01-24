<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Combo;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::where('featured', true)
            ->where('is_active', true)
            ->with(['category', 'variants'])
            ->take(6)
            ->get();

        // Fetch active sales (formerly deals)
        // using Sale model which has starts_at/ends_at
        $activeSales = \App\Models\Sale::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            })
            ->with('products')
            ->first(); // Get just one active sale for homepage

        // Fetch active bundles (formerly combos -> now Deals)
        // using Deal model which has start_date/end_date
        $activeBundles = Deal::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->with(['products', 'items'])
            ->take(3)
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'activeSales', 'activeBundles'));
    }
}
