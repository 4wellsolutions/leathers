<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Product $product)
    {
        return view('reviews.create', compact('product'));
    }

    public function createForOrder(\App\Models\Order $order)
    {
        $order->load(['items.product']);
        return view('reviews.order', compact('order'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // In a real app, you'd check if the user actually purchased the item
        // For now, we'll allow guest reviews or authenticated user reviews

        Review::create([
            'user_id' => auth()->id(), // Nullable for guests
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true, // Auto-approve for now
        ]);

        return redirect()->route('products.show', $product->slug)
            ->with('success', 'Thank you for your review!');
    }
}
