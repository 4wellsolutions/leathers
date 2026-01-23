<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured === 'yes');
        }

        // Price range filter
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Stats
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'inactive' => Product::where('is_active', false)->count(),
            'low_stock' => Product::where('stock', '<', 10)->count(),
        ];

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
        $deals = \App\Models\Deal::where('is_active', true)->get();
        return view('admin.products.create', compact('categories', 'deals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'deal_id' => 'nullable|exists:deals,id',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'daraz_url' => 'nullable|url',
        ]);

        // Set defaults for variant-based pricing
        $validated['price'] = $validated['price'] ?? 0;
        $validated['stock'] = $validated['stock'] ?? 0;

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'products/' . $validated['slug'] . '.' . $extension;
            $file->storeAs('', $filename, 'public_root');
            $validated['image'] = $filename;
        }

        $product = Product::create($validated);

        $this->saveVariants($product, $request);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'data' => $product,
                'redirect' => route('admin.products.index')
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $deals = \App\Models\Deal::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories', 'deals'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'deal_id' => 'nullable|exists:deals,id',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'daraz_url' => 'nullable|url',
            'size_guide_image' => 'nullable|image|max:2048',
        ]);

        // Set defaults for variant-based pricing
        $validated['price'] = $validated['price'] ?? $product->price ?? 0;
        $validated['stock'] = $validated['stock'] ?? $product->stock ?? 0;

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && \Storage::disk('public_root')->exists($product->image)) {
                \Storage::disk('public_root')->delete($product->image);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $slug = $validated['slug'] ?? $product->slug;
            $filename = 'products/' . $slug . '.' . $extension;
            $file->storeAs('', $filename, 'public_root');
            $validated['image'] = $filename;
        } elseif ($request->boolean('remove_main_image')) {
            if ($product->image && \Storage::disk('public_root')->exists($product->image)) {
                \Storage::disk('public_root')->delete($product->image);
            }
            $validated['image'] = null;
        }

        // Handle Size Guide image upload
        if ($request->hasFile('size_guide_image')) {
            if ($product->size_guide_image && \Storage::disk('public_root')->exists($product->size_guide_image)) {
                \Storage::disk('public_root')->delete($product->size_guide_image);
            }
            $file = $request->file('size_guide_image');
            $extension = $file->getClientOriginalExtension();
            $slug = $validated['slug'] ?? $product->slug;
            $filename = 'products/size-guides/' . $slug . '-size-guide.' . $extension;
            $file->storeAs('', $filename, 'public_root');
            $validated['size_guide_image'] = $filename;
        } elseif ($request->boolean('remove_size_guide_image')) {
            if ($product->size_guide_image && \Storage::disk('public_root')->exists($product->size_guide_image)) {
                \Storage::disk('public_root')->delete($product->size_guide_image);
            }
            $validated['size_guide_image'] = null;
        }

        $product->update($validated);

        $this->saveVariants($product, $request);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'data' => $product->fresh(),
                'reload' => true
            ]);
        }

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product updated successfully');

    }

    private function saveVariants($product, $request)
    {
        if ($request->has('colors')) {
            $submittedColorIds = [];

            foreach ($request->colors as $colorIndex => $colorData) {
                // Prepare Color Data
                $colorAttributes = [
                    'name' => $colorData['name'],
                    'color_code' => $colorData['color_code'] ?? null,
                ];

                // Handle Color Image
                if ($request->hasFile("colors.{$colorIndex}.image")) {
                    $file = $request->file("colors.{$colorIndex}.image");
                    $extension = $file->getClientOriginalExtension();
                    $colorSlug = \Str::slug($colorData['name']);
                    $filename = 'product-colors/' . $product->slug . '-' . $colorSlug . '.' . $extension;
                    $file->storeAs('', $filename, 'public_root');
                    $colorAttributes['image'] = $filename;
                } elseif (!empty($colorData['remove_image']) && $colorData['remove_image'] == '1') {
                    $colorAttributes['image'] = null;
                }

                // Create or Update Color
                if (!empty($colorData['id'])) {
                    $color = \App\Models\ProductColor::find($colorData['id']);
                    if ($color) {
                        // Handle Single Color Ionc/Main Image Replacement (Existing logic)
                        if ((isset($colorAttributes['image']) || (!empty($colorData['remove_image']) && $colorData['remove_image'] == '1')) && $color->image) {
                            if (\Storage::disk('public_root')->exists($color->image)) {
                                \Storage::disk('public_root')->delete($color->image);
                            }
                        }
                        $color->update($colorAttributes);
                        $submittedColorIds[] = $color->id;
                    }
                } else {
                    $color = $product->colors()->create($colorAttributes);
                    $submittedColorIds[] = $color->id;
                }

                if ($color) {
                    // Handle Color Images
                    // Start with existing images from the form (not removed ones)
                    $currentColorImages = [];
                    if (isset($colorData['existing_images']) && is_array($colorData['existing_images'])) {
                        $currentColorImages = $colorData['existing_images'];
                    }

                    // 1. Remove deleted images (already handled by not including them in existing_images)
                    // But we still need to delete the files from storage
                    if (isset($colorData['removed_images']) && is_array($colorData['removed_images'])) {
                        foreach ($colorData['removed_images'] as $removedImage) {
                            if (\Storage::disk('public_root')->exists($removedImage)) {
                                \Storage::disk('public_root')->delete($removedImage);
                            }
                        }
                    }

                    // 2. Add new color images
                    if ($request->hasFile("colors.{$colorIndex}.images")) {
                        $counter = count($currentColorImages) + 1;
                        foreach ($request->file("colors.{$colorIndex}.images") as $imageFile) {
                            $extension = $imageFile->getClientOriginalExtension();
                            // Naming: product-slug-color-name-count.ext
                            $colorSlugForImages = \Str::slug($product->slug . '-' . $color->name);
                            $filename = 'products/colors/' . $colorSlugForImages . '-' . $counter . '-' . uniqid() . '.' . $extension;
                            $imageFile->storeAs('', $filename, 'public_root');
                            $currentColorImages[] = $filename;
                            $counter++;
                        }
                    }

                    $color->update(['images' => $currentColorImages]);
                    // ---------------------------------------------

                    // Handle Sizes (Variants)
                    $submittedVariantIds = [];
                    if (isset($colorData['sizes']) && is_array($colorData['sizes'])) {
                        foreach ($colorData['sizes'] as $sizeIndex => $sizeData) {
                            $variantAttributes = [
                                'product_id' => $product->id,
                                'name' => $colorData['name'] . ' - ' . $sizeData['name'],
                                'size' => $sizeData['name'],
                                'stock' => $sizeData['stock'] ?? 0,
                                'price' => $sizeData['price'] ?? null,
                                'sale_price' => $sizeData['sale_price'] ?? null,
                                'sku' => $sizeData['sku'] ?? null,
                            ];

                            // Determine Variant Object for Logic
                            $variant = null;
                            if (!empty($sizeData['id'])) {
                                $variant = \App\Models\ProductVariant::find($sizeData['id']);
                                if ($variant) {
                                    $variant->update($variantAttributes);
                                    $submittedVariantIds[] = $variant->id;
                                }
                            } else {
                                $variant = $color->variants()->create($variantAttributes);
                                $submittedVariantIds[] = $variant->id;
                            }

                            if ($variant) {
                                // Variant Image Logic Removed
                            }
                        }
                    }
                    // Delete removed sizes
                    $color->variants()->whereNotIn('id', $submittedVariantIds)->delete();
                }
            }

            // Delete removed colors
            $product->colors()->whereNotIn('id', $submittedColorIds)->each(function ($color) {
                if ($color->image) {
                    \Storage::disk('public_root')->delete($color->image);
                }
                $color->delete();
            });
        }
    }

    public function toggleStatus(Request $request, Product $product)
    {
        $request->validate([
            'field' => 'required|in:is_active,featured',
            'value' => 'required|boolean'
        ]);

        $product->update([
            $request->field => $request->value
        ]);

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $request->field)) . ' updated successfully!'
        ]);
    }

    public function destroy(Product $product)
    {
        // 1. Delete Main Image
        if ($product->image && \Storage::disk('public_root')->exists($product->image)) {
            \Storage::disk('public_root')->delete($product->image);
        }

        // 2. Delete Gallery Images
        if ($product->images) {
            $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
            if (is_array($images)) {
                foreach ($images as $image) {
                    if (\Storage::disk('public_root')->exists($image)) {
                        \Storage::disk('public_root')->delete($image);
                    }
                }
            }
        }

        // 3. Delete Size Guide Image
        if ($product->size_guide_image && \Storage::disk('public_root')->exists($product->size_guide_image)) {
            \Storage::disk('public_root')->delete($product->size_guide_image);
        }

        // 4. Delete Color Images
        foreach ($product->colors as $color) {
            if ($color->image && \Storage::disk('public_root')->exists($color->image)) {
                \Storage::disk('public_root')->delete($color->image);
            }
            // product_variants will be deleted via cascade on delete of color or product
        }

        // 5. Delete Product Record (Cascade will handle database relations for colors and variants)
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product and all related data deleted successfully');
    }
}
