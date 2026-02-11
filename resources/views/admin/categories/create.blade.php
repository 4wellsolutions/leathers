@extends('layouts.admin')

@section('title', 'Add New Category')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="POST" class="pb-20" enctype="multipart/form-data">
        @csrf

        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Add New Category</h1>
                <p class="text-sm text-neutral-500">Create a new product category.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all transform hover:-translate-y-0.5">
                    Create Category
                </button>
            </div>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="p-6 md:p-8 space-y-6">
                    <h2 class="text-lg font-semibold text-leather-900 border-b border-neutral-100 pb-4 mb-6">Category
                        Details</h2>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4"
                                placeholder="e.g. Leather Belts">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-neutral-700 mb-2">URL Slug</label>
                            <div class="flex rounded-lg shadow-sm">
                                <span
                                    class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
                                    {{ config('app.url') }}/category/
                                </span>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                    class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-lg focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300"
                                    placeholder="leather-belts">
                            </div>
                            <p class="mt-1 text-xs text-neutral-500">Leave empty to auto-generate from name</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-medium text-neutral-700 mb-2">Category Image
                                (Square 1:1)</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-md hover:border-gold-500 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-neutral-600">
                                        <label for="image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-gold-600 hover:text-gold-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-gold-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-neutral-500">PNG, JPG up to 2MB (must be 1:1 aspect ratio)</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-neutral-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4"
                                placeholder="Category description...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-neutral-100">
                        <h3 class="text-base font-semibold text-leather-900 mb-4">SEO Settings</h3>

                        <div class="space-y-6">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-neutral-700 mb-2">Meta
                                    Title</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-neutral-700 mb-2">Meta
                                    Description</label>
                                <textarea id="meta_description" name="meta_description" rows="3"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('meta_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection