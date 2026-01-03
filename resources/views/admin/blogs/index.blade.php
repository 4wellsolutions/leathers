@extends('layouts.admin')

@section('title', 'Blog Posts')

@section('content')
    <!-- Sticky Header -->
    <div
        class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Blog Posts</h1>
                <p class="text-sm text-neutral-500">Manage your blog content</p>
            </div>
            <a href="{{ route('admin.blogs.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Post
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-5 mb-8">
        <div
            class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-leather-100 text-leather-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total Posts</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-leather-900">{{ $stats['total'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100 text-green-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Published</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-green-600">{{ $stats['published'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-yellow-100 text-yellow-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Drafts</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-yellow-600">{{ $stats['drafts'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-purple-100 text-purple-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Scheduled</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-purple-600">{{ $stats['scheduled'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-blue-100 text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total Views</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-blue-600">{{ number_format($stats['total_views']) }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 mb-8">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.blogs.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <label for="search" class="block text-sm font-medium text-neutral-700 mb-2">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                        placeholder="Search posts...">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-neutral-700 mb-2">Category</label>
                    <select name="category" id="category"
                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-neutral-700 mb-2">Status</label>
                    <select name="status" id="status"
                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-neutral-700 mb-2">Author</label>
                    <select name="author" id="author"
                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm">
                        <option value="">All Authors</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-6 flex items-end space-x-3">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-leather-900 hover:bg-leather-800">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.blogs.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-lg shadow-sm text-neutral-700 bg-white hover:bg-neutral-50">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Blog Posts Table -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                            Category</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Author
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Views
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @forelse($blogs as $blog)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($blog->featured_image)
                                        <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}"
                                            class="h-10 w-10 rounded object-cover mr-3">
                                    @else
                                        <div class="h-10 w-10 rounded bg-neutral-200 mr-3 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-leather-900">{{ Str::limit($blog->title, 50) }}
                                        </div>
                                        @if($blog->featured)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gold-100 text-gold-800">
                                                ⭐ Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900">{{ $blog->category->name ?? 'Uncategorized' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900">{{ $blog->author->name ?? 'Unknown Author' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'published' => 'bg-green-100 text-green-800',
                                        'draft' => 'bg-yellow-100 text-yellow-800',
                                        'scheduled' => 'bg-purple-100 text-purple-800',
                                    ];
                                    $statusClass = $statusClasses[$blog->status] ?? 'bg-neutral-100 text-neutral-800';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ ucfirst($blog->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900">{{ number_format($blog->views) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900">
                                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Not published' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                    class="text-gold-600 hover:text-gold-900 mr-4">Edit</a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-neutral-900">No blog posts found</h3>
                                <p class="mt-1 text-sm text-neutral-500">Get started by creating a new post.</p>
                                <div class="mt-6">
                                    <a href="{{ route('admin.blogs.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-leather-900 hover:bg-leather-800">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        New Post
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($blogs->hasPages())
            <div class="bg-white px-4 py-3 border-t border-neutral-200 sm:px-6">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
@endsection