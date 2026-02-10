<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Product::where('is_active', true)->with(['category', 'variants']);

        // Apply price range filter
        if ($request->has('price_range')) {
            $priceRanges = is_array($request->price_range) ? $request->price_range : [$request->price_range];

            $query->where(function ($q) use ($priceRanges) {
                $firstRange = true;
                foreach ($priceRanges as $range) {
                    if ($range === 'under_5000') {
                        if ($firstRange) {
                            $q->where('price', '<', 5000);
                            $firstRange = false;
                        } else {
                            $q->orWhere('price', '<', 5000);
                        }
                    } elseif ($range === '5000_10000') {
                        if ($firstRange) {
                            $q->whereBetween('price', [5000, 10000]);
                            $firstRange = false;
                        } else {
                            $q->orWhereBetween('price', [5000, 10000]);
                        }
                    } elseif ($range === 'over_10000') {
                        if ($firstRange) {
                            $q->where('price', '>', 10000);
                            $firstRange = false;
                        } else {
                            $q->orWhere('price', '>', 10000);
                        }
                    }
                }
            });
        }

        // Apply sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->appends($request->query());
        $categories = \App\Models\Category::all();
        $currentCategory = null;

        return view('products.index', compact('products', 'categories', 'currentCategory'));
    }

    public function category(Request $request, $slug)
    {
        $currentCategory = \App\Models\Category::where('slug', $slug)->firstOrFail();

        $query = \App\Models\Product::where('is_active', true)
            ->where('category_id', $currentCategory->id)
            ->with('category');

        // Apply price range filter
        if ($request->has('price_range')) {
            $priceRanges = is_array($request->price_range) ? $request->price_range : [$request->price_range];

            $query->where(function ($q) use ($priceRanges) {
                $firstRange = true;
                foreach ($priceRanges as $range) {
                    if ($range === 'under_5000') {
                        if ($firstRange) {
                            $q->where('price', '<', 5000);
                            $firstRange = false;
                        } else {
                            $q->orWhere('price', '<', 5000);
                        }
                    } elseif ($range === '5000_10000') {
                        if ($firstRange) {
                            $q->whereBetween('price', [5000, 10000]);
                            $firstRange = false;
                        } else {
                            $q->orWhereBetween('price', [5000, 10000]);
                        }
                    } elseif ($range === 'over_10000') {
                        if ($firstRange) {
                            $q->where('price', '>', 10000);
                            $firstRange = false;
                        } else {
                            $q->orWhere('price', '>', 10000);
                        }
                    }
                }
            });
        }

        // Apply sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(15)->appends($request->query());
        $categories = \App\Models\Category::all();

        return view('products.index', compact('products', 'categories', 'currentCategory'));
    }

    public function show($slug)
    {
        $product = \App\Models\Product::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'category',
                'variants' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->firstOrFail();

        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function sales()
    {
        $products = \App\Models\Product::where('is_active', true)
            ->where('price', '>', 0)
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->whereNotNull('sale_starts_at')
            ->where('sale_starts_at', '<=', now())
            ->whereNotNull('sale_ends_at')
            ->where('sale_ends_at', '>=', now())
            ->with(['category', 'variants'])
            ->paginate(12);

        $categories = \App\Models\Category::all();
        $currentCategory = null;

        return view('products.index', compact('products', 'categories', 'currentCategory'));
    }
}
