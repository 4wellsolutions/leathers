@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" class="pb-20">
        @csrf
        @method('PUT')

        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Edit Blog Post</h1>
                <p class="text-sm text-neutral-500">Update and republish your article.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.blogs.index') }}"
                    class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50">
                    Cancel
                </a>
                <button type="submit" name="status" value="draft"
                    class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50">
                    Save Draft
                </button>
                <button type="submit" name="status" value="published"
                    class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 shadow-sm">
                    Update & Publish
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Main Content (8 cols) -->
            <div class="lg:col-span-8 space-y-8">

                <!-- Basic Details Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 md:p-8 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-neutral-700 mb-2">Blog Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $blog->title) }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-lg font-semibold py-3 px-4"
                                required>
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-neutral-700 mb-2">URL Slug</label>
                            <div class="flex rounded-lg shadow-sm">
                                <span
                                    class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
                                    {{ config('app.url') }}/blog/
                                </span>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $blog->slug) }}"
                                    class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-lg focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300">
                            </div>
                        </div>

                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-neutral-700 mb-2">Excerpt</label>
                            <textarea id="excerpt" name="excerpt" rows="3"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('excerpt', $blog->excerpt) }}</textarea>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-neutral-700 mb-2">Content</label>
                            <textarea id="content" name="content" rows="20"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('content', $blog->content) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SEO Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 md:p-8 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 border-b border-neutral-100 pb-4">SEO Settings
                        </h2>

                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-neutral-700 mb-2">Meta
                                Title</label>
                            <input type="text" name="meta_title" id="meta_title"
                                value="{{ old('meta_title', $blog->meta_title) }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-neutral-700 mb-2">Meta
                                Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-8">

                <!-- Publishing Options -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Publish</h2>

                        <div class="text-sm text-neutral-600 mb-4">
                            <strong>Views:</strong> {{ number_format($blog->views) }}
                        </div>

                        <div>
                            <label for="published_at" class="block text-sm font-medium text-neutral-700 mb-2">Publish
                                Date</label>
                            <input type="datetime-local" name="published_at" id="published_at"
                                value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-2.5 px-4">
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Featured Post</span>
                                <span class="text-xs text-neutral-500">Highlight on homepage</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="featured" value="1" {{ old('featured', $blog->featured) ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Allow Comments</span>
                                <span class="text-xs text-neutral-500">Enable reader comments</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="allow_comments" value="1" {{ old('allow_comments', $blog->allow_comments) ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Category</h2>

                        <div>
                            <select id="blog_category_id" name="blog_category_id"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                                <option value="">Uncategorized</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('blog_category_id', $blog->blog_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Featured Image</h2>

                        <div id="featured_image_preview" class="{{ $blog->featured_image ? '' : 'hidden' }}">
                            <img src="{{ $blog->featured_image ? asset($blog->featured_image) : '' }}" alt="Featured image"
                                class="w-full h-48 object-cover rounded-lg mb-3">
                            <button type="button" onclick="removeFeaturedImage()"
                                class="text-sm text-red-600 hover:text-red-900">Remove Image</button>
                        </div>

                        <div id="featured_image_placeholder"
                            class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-neutral-300 rounded-lg hover:bg-neutral-50 cursor-pointer {{ $blog->featured_image ? 'hidden' : '' }}">
                            <svg class="h-12 w-12 text-neutral-400 mb-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-neutral-600">Click to select image</p>
                        </div>

                        <input type="hidden" name="featured_image" id="featured_image"
                            value="{{ old('featured_image', $blog->featured_image) }}">
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Tags</h2>

                        <div>
                            <input type="text" id="tags_input" value="{{ $blog->tags ? implode(', ', $blog->tags) : '' }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4"
                                placeholder="Add tags (comma separated)">
                        </div>

                        <input type="hidden" name="tags" id="tags" value="{{ old('tags', json_encode($blog->tags)) }}">
                    </div>
                </div>

            </div>
        </div>
    </form>

    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'preview', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image media link | code | help',
            content_style: 'body { font-family:Inter,Arial,sans-serif; font-size:14px }'
        });

        function removeFeaturedImage() {
            document.getElementById('featured_image').value = '';
            document.getElementById('featured_image_preview').classList.add('hidden');
            document.getElementById('featured_image_placeholder').classList.remove('hidden');
        }

        // Tags handling
        document.getElementById('tags_input').addEventListener('change', function (e) {
            const tags = e.target.value.split(',').map(tag => tag.trim()).filter(tag => tag);
            document.getElementById('tags').value = JSON.stringify(tags);
        });
    </script>
@endsection