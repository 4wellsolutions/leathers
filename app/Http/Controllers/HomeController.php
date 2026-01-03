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

        // Fetch active deals with products
        $activeDeals = Deal::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            })
            ->has('products')
            ->with('products')
            ->first(); // Get just one active deal for homepage

        // Fetch active combos
        $activeCombos = Combo::where('is_active', true)
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

        return view('home', compact('categories', 'featuredProducts', 'activeDeals', 'activeCombos'));
    }
}
