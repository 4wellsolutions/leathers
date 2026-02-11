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
        ], [
            'images.*.uploaded' => 'The image failed to upload. This usually happens if the file is larger than the server allows (check php.ini upload_max_filesize).',
            'images.*.max' => 'The image must not be larger than 2MB.',
            'images.*.image' => 'The file must be an image (jpg, jpeg, png, gif).',
        ]);

        $data = $request->only(['product_id', 'rating', 'comment', 'is_anonymous', 'is_approved']);
        $data['user_id'] = null; // Admin created reviews are not linked to a user by default, or could link to admin
        $data['is_approved'] = $request->has('is_approved'); // Default to true if checked
        $data['is_anonymous'] = $request->has('is_anonymous');

        if ($request->hasFile('images')) {
            $images = [];
            $path = public_path('reviews');

            try {
                \Illuminate\Support\Facades\File::ensureDirectoryExists($path, 0755, true);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to ensure directory exists: ' . $path . ' Error: ' . $e->getMessage());
            }

            foreach ($request->file('images') as $image) {
                try {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($path, $filename);
                    $images[] = 'reviews/' . $filename;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to move uploaded review image to ' . $path . '. Error: ' . $e->getMessage());
                    throw $e; // Re-throw to show error to user
                }
            }
            $data['images'] = $images;
        }

        $review = Review::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review created successfully.',
                'redirect_url' => route('admin.reviews.index'),
            ]);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully.');
    }

    public function edit(Review $review)
    {
        $products = Product::select('id', 'name', 'image')->orderBy('name')->get();
        return view('admin.reviews.edit', compact('review', 'products'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'product_id' => 'sometimes|exists:products,id',
            'rating' => 'sometimes|integer|min:1|max:5',
            'is_approved' => 'sometimes|boolean',
            'comment' => 'sometimes|string|max:1000',
            'is_anonymous' => 'sometimes|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'images.*.uploaded' => 'The image failed to upload. This usually happens if the file is larger than the server allows (check php.ini upload_max_filesize).',
            'images.*.max' => 'The image must not be larger than 2MB.',
            'images.*.image' => 'The file must be an image (jpg, jpeg, png, gif).',
        ]);

        $data = $request->only(['product_id', 'rating', 'comment']);
        $data['is_approved'] = $request->has('is_approved');
        $data['is_anonymous'] = $request->has('is_anonymous');

        if ($request->hasFile('images')) {
            $images = $review->images ?? [];
            $path = public_path('reviews');

            try {
                \Illuminate\Support\Facades\File::ensureDirectoryExists($path, 0755, true);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to ensure directory exists: ' . $path . ' Error: ' . $e->getMessage());
            }

            foreach ($request->file('images') as $image) {
                try {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($path, $filename);
                    $images[] = 'reviews/' . $filename;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to move uploaded review image to ' . $path . ' during update. Error: ' . $e->getMessage());
                    throw $e;
                }
            }
            $data['images'] = $images;
        }

        $review->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review updated successfully.',
                'redirect_url' => route('admin.reviews.index'),
            ]);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        // Delete images if needed (optional, keeping it simple for now)
        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
