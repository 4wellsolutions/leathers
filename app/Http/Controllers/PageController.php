<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();
        
        $meta_title = $page->meta_title ?? $page->title;
        $meta_description = $page->meta_description ?? Str::limit(strip_tags($page->content), 160);

        return view('pages.show', compact('page', 'meta_title', 'meta_description'));
    }
}
