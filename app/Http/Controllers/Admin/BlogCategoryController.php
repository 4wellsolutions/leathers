<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('blogs')->latest()->paginate(15);
        
        $stats = [
            'total' => BlogCategory::count(),
            'with_posts' => BlogCategory::has('blogs')->count(),
            'empty' => BlogCategory::doesntHave('blogs')->count(),
        ];

        return view('admin.blog-categories.index', compact('categories', 'stats'));
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_categories',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        BlogCategory::create($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category created successfully');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_categories,slug,' . $blogCategory->id,
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $blogCategory->update($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category updated successfully');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        if ($blogCategory->blogs()->count() > 0) {
            return redirect()->route('admin.blog-categories.index')->with('error', 'Cannot delete category with existing posts');
        }

        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category deleted successfully');
    }
}
