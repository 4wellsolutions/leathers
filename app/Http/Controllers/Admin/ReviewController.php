<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user']);

        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $products = Product::select('id', 'name', 'image')->orderBy('name')->get();
        return view('admin.reviews.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'sometimes|boolean',
            'is_approved' => 'sometimes|boolean',
        ]);

        $data = $request->only(['product_id', 'rating', 'comment', 'is_anonymous', 'is_approved']);
        $data['user_id'] = null; // Admin created reviews are not linked to a user by default, or could link to admin
        $data['is_approved'] = $request->has('is_approved'); // Default to true if checked
        $data['is_anonymous'] = $request->has('is_anonymous');

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('reviews', 'public');
            }
            $data['images'] = $images;
        }

        Review::create($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully.');
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'is_approved' => 'sometimes|boolean',
            'comment' => 'sometimes|string|max:1000',
        ]);

        $review->update($request->only(['is_approved', 'comment']));

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        // Delete images if needed (optional, keeping it simple for now)
        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
