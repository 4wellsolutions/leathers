@extends('layouts.admin')

@section('title', 'Edit Category: ' . $category->name)

@section('content')
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="pb-20">
        @csrf
        @method('PUT')
        
        <!-- Sticky Header -->
        <div class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Edit Category</h1>
                <p class="text-sm text-neutral-500">Update category information.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all transform hover:-translate-y-0.5">
                    Update Category
                </button>
            </div>
        </div>
        
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="p-6 md:p-8 space-y-6">
                    <h2 class="text-lg font-semibold text-leather-900 border-b border-neutral-100 pb-4 mb-6">Category Details</h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-neutral-700 mb-2">URL Slug</label>
                            <div class="flex rounded-lg shadow-sm">
                                <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
                                    {{ config('app.url') }}/category/
                                </span>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-lg focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300">
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-neutral-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-neutral-100">
                        <h3 class="text-base font-semibold text-leather-900 mb-4">SEO Settings</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-neutral-700 mb-2">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $category->meta_title) }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-neutral-700 mb-2">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="3" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('meta_description', $category->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
