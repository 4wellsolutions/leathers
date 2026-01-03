@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <!-- Sticky Header -->
    <div class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Categories</h1>
                <p class="text-sm text-neutral-500">Organize your products</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Category
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-leather-100 text-leather-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total Categories</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-leather-900">{{ $stats['total'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100 text-green-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">With Products</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-green-600">{{ $stats['active'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-neutral-100 text-neutral-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Empty</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-neutral-600">{{ $stats['empty'] }}</div>
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
            <form method="GET" action="{{ route('admin.categories.index') }}" class="flex items-end space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-neutral-700 mb-2">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm" placeholder="Search categories...">
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-lg shadow-sm text-neutral-700 bg-white hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Slug</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Products</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-leather-900">{{ $category->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-500">{{ $category->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-leather-100 text-leather-800">
                                    {{ $category->products_count }} products
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-neutral-500 max-w-xs truncate">
                                    {{ $category->description ?? 'No description' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-gold-600 hover:text-gold-900 mr-3">Edit</a>
                                <a href="{{ route('category.show', $category->slug) }}" target="_blank" class="text-neutral-600 hover:text-neutral-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-neutral-900">No categories found</h3>
                                <p class="mt-1 text-sm text-neutral-500">Get started by creating a new category.</p>
                                <div class="mt-6">
                                    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        New Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="bg-white px-4 py-3 border-t border-neutral-200 sm:px-6">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
