<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Blog, BlogCategory, User};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'author']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Author filter
        if ($request->filled('author')) {
            $query->where('user_id', $request->author);
        }

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Stats
        $stats = [
            'total' => Blog::count(),
            'published' => Blog::where('status', 'published')->count(),
            'drafts' => Blog::where('status', 'draft')->count(),
            'scheduled' => Blog::where('status', 'scheduled')->count(),
            'total_views' => Blog::sum('views'),
        ];

        $blogs = $query->latest()->paginate(15)->withQueryString();
        $categories = BlogCategory::all();
        $authors = User::where('is_admin', true)->get();

        return view('admin.blogs.index', compact('blogs', 'categories', 'authors', 'stats'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs',
            'excerpt' => 'nullable|string',
            'content' => '

required|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|string',
            'gallery_images' => 'nullable|array',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'tags' => 'nullable|array',
            'featured' => 'boolean',
            'allow_comments' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['user_id'] = auth()->id();

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|string',
            'gallery_images' => 'nullable|array',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'tags' => 'nullable|array',
            'featured' => 'boolean',
            'allow_comments' => 'boolean',
        ]);

        if ($validated['status'] === 'published' && empty($blog->published_at) && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully');
    }

    public function destroy(Blog $blog)
    {
        // Delete featured image if exists
        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully');
    }
}
