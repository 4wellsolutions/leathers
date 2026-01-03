<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class FrontendBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $blog->incrementViews();

        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->limit(3)
            ->get();

        return view('blog.show', compact('blog', 'relatedBlogs'));
    }
}
