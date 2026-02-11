<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Stats
        $stats = [
            'total' => Category::count(),
            'active' => Category::has('products')->count(),
            'empty' => Category::doesntHave('products')->count(),
        ];

        $categories = $query->latest()->paginate(15)->withQueryString();

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:ratio=1/1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ], [
            'image.uploaded' => 'The image failed to upload. This usually happens if the file is larger than the server allows (check php.ini upload_max_filesize).',
            'image.max' => 'The image must not be larger than 2MB.',
            'image.dimensions' => 'The image must have a 1:1 aspect ratio (square).',
            'image.image' => 'The file must be an image (jpg, jpeg, png, gif).',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('categories'), $filename);
            $validated['image'] = 'categories/' . $filename;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:ratio=1/1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ], [
            'image.uploaded' => 'The image failed to upload. This usually happens if the file is larger than the server allows (check php.ini upload_max_filesize).',
            'image.max' => 'The image must not be larger than 2MB.',
            'image.dimensions' => 'The image must have a 1:1 aspect ratio (square).',
            'image.image' => 'The file must be an image (jpg, jpeg, png, gif).',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path($category->image))) {
                @unlink(public_path($category->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('categories'), $filename);
            $validated['image'] = 'categories/' . $filename;
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }
}
