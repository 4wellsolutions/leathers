@extends('layouts.admin')

@section('title', 'Create Page')

@section('content')
    <form action="{{ route('admin.pages.store') }}" method="POST" class="pb-20">
        @csrf
        
        <!-- Sticky Header -->
        <div class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Create Page</h1>
                <p class="text-sm text-neutral-500">Add a new static page to your website.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 shadow-sm">
                    Publish Page
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
                            <label for="title" class="block text-sm font-medium text-neutral-700 mb-2">Page Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-lg font-semibold py-3 px-4" placeholder="e.g., Privacy Policy" required>
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-neutral-700 mb-2">URL Slug</label>
                            <div class="flex rounded-lg shadow-sm">
                                <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
                                    {{ config('app.url') }}/page/
                                </span>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-lg focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300">
                            </div>
                             <p class="mt-1 text-xs text-neutral-500">Leave empty to auto-generate from title</p>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-neutral-700 mb-2">Page Content</label>
                            <!-- Custom Editor Container -->
                            <div class="border border-neutral-300 rounded-lg overflow-hidden bg-white shadow-sm focus-within:border-gold-500 focus-within:ring-1 focus-within:ring-gold-500 transition-all flex flex-col h-full min-h-[600px]">
                                <!-- Toolbar -->
                                <div class="bg-neutral-50 border-b border-neutral-200 p-2 flex flex-wrap gap-1 sticky top-0 z-10">
                                    <div class="flex items-center gap-1 border-r border-neutral-300 pr-2 mr-1">
                                        <select onchange="execCmd('formatBlock', this.value); this.value=''" class="h-8 text-sm border-neutral-300 rounded focus:ring-gold-500 focus:border-gold-500 bg-white">
                                            <option value="">Paragraph</option>
                                            <option value="h1">Heading 1</option>
                                            <option value="h2">Heading 2</option>
                                            <option value="h3">Heading 3</option>
                                        </select>
                                    </div>
                                    <button type="button" onclick="execCmd('bold')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700 font-bold">B</button>
                                    <button type="button" onclick="execCmd('italic')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700 italic">I</button>
                                    <button type="button" onclick="execCmd('underline')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700 underline">U</button>
                                    <div class="h-6 w-px bg-neutral-300 mx-1 self-center"></div>
                                    <button type="button" onclick="execCmd('insertUnorderedList')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700">List</button>
                                    <button type="button" onclick="createLink()" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700">Link</button>
                                    <button type="button" onclick="execCmd('removeFormat')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700">Clear</button>
                                </div>
                                
                                <!-- Editor Area -->
                                <div id="editor" class="flex-grow p-4 outline-none prose prose-indigo max-w-none overflow-y-auto" contenteditable="true">
                                    {!! old('content') !!}
                                </div>
                                <input type="hidden" name="content" id="contentInput" value="{{ old('content') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 md:p-8 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 border-b border-neutral-100 pb-4">SEO Settings</h2>
                        
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-neutral-700 mb-2">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-neutral-700 mb-2">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-8">
                
                <!-- Publishing Options -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Publishing</h2>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Status</span>
                                <span class="text-xs text-neutral-500">Visible to public</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Include in Sitemap</span>
                                <span class="text-xs text-neutral-500">Search engines index</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="include_in_sitemap" value="1" {{ old('include_in_sitemap', true) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function execCmd(command, value = null) {
            document.execCommand(command, false, value);
            updateContentInput();
        }

        function createLink() {
            const url = prompt("Enter link URL:", "http://");
            if(url) execCmd('createLink', url);
        }

        function updateContentInput() {
            document.getElementById('contentInput').value = document.getElementById('editor').innerHTML;
        }

        document.getElementById('editor').addEventListener('input', updateContentInput);
        document.getElementById('editor').addEventListener('blur', updateContentInput);

        // Auto-slug
        document.getElementById('title').addEventListener('input', function(e) {
            if (!document.getElementById('slug').value) {
                document.getElementById('slug').value = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');
            }
        });
    </script>
@endsection
