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

    public function createForOrder($order_number)
    {
        $order = \App\Models\Order::where('order_number', $order_number)->firstOrFail();
        $order->load(['items.product']);
        return view('reviews.order', compact('order'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $images = [];
        $video = null;

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                // Store in public/reviews folder
                $path = $file->store('reviews', 'public');
                $mime = $file->getMimeType();

                // Simple check for video MIME type
                if (str_starts_with($mime, 'video/')) {
                    $video = $path;
                } else {
                    $images[] = $path;
                }
            }
        }

        Review::create([
            'user_id' => auth()->id(), // Nullable for guests
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => !empty($images) ? $images : null,
            'video' => $video,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'is_approved' => true, // Auto-approve for now
        ]);

        return redirect()->route('products.show', $product->slug)
            ->with('success', 'Thank you for your review!');
    }
}
