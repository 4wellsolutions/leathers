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

        $reviewedProductIds = [];
        if ($order->user_id) {
            $reviewedProductIds = Review::where('user_id', $order->user_id)
                ->whereIn('product_id', $order->items->pluck('product_id'))
                ->pluck('product_id')
                ->toArray();
        }

        return view('reviews.order', compact('order', 'reviewedProductIds'));
    }

    public function createFromOrder($order_number, Product $product, $variant_id = null)
    {
        // 1. Verify Order exists
        $order = \App\Models\Order::where('order_number', $order_number)->firstOrFail();

        // 2. Verify User owns order (if logged in) or simple check
        if (auth()->check() && $order->user_id && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // 3. Verify Product is in Order and get the specific item
        $query = $order->items()->where('product_id', $product->id);

        if ($variant_id) {
            $query->where('variant_id', $variant_id);
        }

        $orderItem = $query->first();

        if (!$orderItem) {
            abort(404, 'Product variant not found in this order.');
        }

        // 4. Verify Not Already Reviewed
        $existingReview = null;
        if ($order->user_id) {
            $existingReview = Review::where('user_id', $order->user_id)
                ->where('product_id', $product->id)
                ->first();
        }

        if ($existingReview) {
            return view('reviews.create', compact('product', 'order', 'orderItem', 'existingReview'));
        }

        return view('reviews.create', compact('product', 'order', 'orderItem'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:2048',
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
            'is_approved' => false, // Pending approval
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your review has been submitted and is pending approval.',
                'redirect_url' => route('products.show', $product->slug)
            ]);
        }

        return redirect()->route('products.show', $product->slug)
            ->with('success', 'Thank you! Your review has been submitted and is pending approval.');
    }
}
