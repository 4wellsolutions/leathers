@extends('layouts.admin')

@section('title', 'Create Blog Post')

@section('content')
    <form action="{{ route('admin.blogs.store') }}" method="POST" class="pb-20" id="blogForm">
        @csrf
        
        <!-- Sticky Header -->
        <div class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Create Blog Post</h1>
                <p class="text-sm text-neutral-500">Write and publish a new blog article.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.blogs.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50">
                    Cancel
                </a>
                <button type="submit" name="status" value="draft" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50">
                    Save Draft
                </button>
                <button type="submit" name="status" value="published" class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 shadow-sm">
                    Publish
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
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-lg font-semibold py-3 px-4" placeholder="Enter a captivating title..." required>
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-neutral-700 mb-2">URL Slug</label>
                            <div class="flex rounded-lg shadow-sm">
                                <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
                                    {{ config('app.url') }}/blog/
                                </span>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-lg focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300">
                            </div>
                             <p class="mt-1 text-xs text-neutral-500">Leave empty to auto-generate from title</p>
                        </div>

                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-neutral-700 mb-2">Excerpt</label>
                            <textarea id="excerpt" name="excerpt" rows="3" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4" placeholder="Brief summary of the post...">{{ old('excerpt') }}</textarea>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-neutral-700 mb-2">Content</label>
                            <!-- Custom Editor Container -->
                            <div class="border border-neutral-300 rounded-lg overflow-hidden bg-white shadow-sm focus-within:border-gold-500 focus-within:ring-1 focus-within:ring-gold-500 transition-all flex flex-col h-full min-h-[800px]">
                                <!-- Toolbar -->
                                <div class="bg-neutral-50 border-b border-neutral-200 p-2 flex flex-wrap gap-1 sticky top-0 z-10" id="editorToolbar">
                                    <!-- Formatting -->
                                    <div class="flex items-center gap-1 border-r border-neutral-300 pr-2 mr-1">
                                        <select onchange="execCmd('formatBlock', this.value); this.value=''" class="h-8 text-sm border-neutral-300 rounded focus:ring-gold-500 focus:border-gold-500 bg-white">
                                            <option value="">Paragraph</option>
                                            <option value="h1">Heading 1</option>
                                            <option value="h2">Heading 2</option>
                                            <option value="h3">Heading 3</option>
                                            <option value="h4">Heading 4</option>
                                            <option value="blockquote">Quote</option>
                                            <option value="pre">Code Block</option>
                                        </select>
                                    </div>
                                    
                                    <button type="button" onclick="execCmd('bold')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Bold"><span class="font-bold">B</span></button>
                                    <button type="button" onclick="execCmd('italic')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Italic"><span class="italic">I</span></button>
                                    <button type="button" onclick="execCmd('underline')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Underline"><span class="underline">U</span></button>
                                    <button type="button" onclick="execCmd('strikeThrough')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Strikethrough"><span class="line-through">S</span></button>

                                    <div class="h-6 w-px bg-neutral-300 mx-1 self-center"></div>

                                    <!-- Alignment -->
                                    <button type="button" onclick="execCmd('justifyLeft')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Align Left">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16" /></svg>
                                    </button>
                                    <button type="button" onclick="execCmd('justifyCenter')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Align Center">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M4 18h16" /></svg>
                                    </button>
                                    <button type="button" onclick="execCmd('justifyRight')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Align Right">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M4 18h16" /></svg>
                                    </button>

                                    <div class="h-6 w-px bg-neutral-300 mx-1 self-center"></div>

                                    <!-- Lists -->
                                    <button type="button" onclick="execCmd('insertUnorderedList')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Bullet List">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                                    </button>
                                    <button type="button" onclick="execCmd('insertOrderedList')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Numbered List">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h12M7 13h12M7 19h12M3 7v.01M3 13v.01M3 19v.01M5 7a2 2 0 11-4 0 2 2 0 014 0zM5 13a2 2 0 11-4 0 2 2 0 014 0zM5 19a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </button>

                                    <div class="h-6 w-px bg-neutral-300 mx-1 self-center"></div>

                                    <!-- Inserts -->
                                    <button type="button" onclick="createLink()" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Insert Link">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                    </button>
                                    <button type="button" onclick="insertImage()" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Insert Media">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </button>
                                    
                                    <div class="h-6 w-px bg-neutral-300 mx-1 self-center"></div>
                                    
                                    <button type="button" onclick="execCmd('removeFormat')" class="p-1.5 rounded hover:bg-neutral-200 text-neutral-700" title="Clear Formatting">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                
                                <!-- Editor Area -->
                                <div id="editor" class="flex-grow p-4 outline-none prose prose-indigo max-w-none overflow-y-auto" contenteditable="true">
                                    {!! old('content') !!}
                                </div>
                                
                                <!-- Editor Footer (Status Bar) -->
                                <div class="bg-neutral-50 border-t border-neutral-200 p-2 text-xs text-neutral-500 flex justify-between items-center">
                                    <div class="flex space-x-4">
                                        <span>Words: <span id="wordCount">0</span></span>
                                        <span>Characters: <span id="charCount">0</span></span>
                                    </div>
                                    <div>
                                        HTML Editor Mode
                                    </div>
                                </div>
                                
                                <input type="hidden" name="content" id="contentInput" value="{{ old('content') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Module -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 md:p-8 space-y-6">
                        <div class="flex justify-between items-center border-b border-neutral-100 pb-4">
                            <h2 class="text-lg font-semibold text-leather-900">SEO Settings & Analysis</h2>
                            <span id="seoScore" class="px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-600">No Analysis</span>
                        </div>
                        
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-neutral-700 mb-2">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                            <div class="mt-1 flex justify-between text-xs text-neutral-500">
                                <span id="metaTitleCount">0 / 60 chars</span>
                                <span id="metaTitleStatus" class="hidden"></span>
                            </div>
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-neutral-700 mb-2">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('meta_description') }}</textarea>
                             <div class="mt-1 flex justify-between text-xs text-neutral-500">
                                <span id="metaDescCount">0 / 160 chars</span>
                                <span id="metaDescStatus" class="hidden"></span>
                            </div>
                        </div>

                        <!-- Real-time Analysis List -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">SEO Analysis</h3>
                            <ul class="space-y-2 text-sm" id="seoAnalysisList">
                                <li class="text-gray-500 flex items-center"><span class="w-2 h-2 bg-gray-300 rounded-full mr-2"></span>Start writing to generate analysis...</li>
                            </ul>
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
                        
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-neutral-700 mb-2">Publish Date</label>
                            <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-2.5 px-4">
                            <p class="mt-1 text-xs text-neutral-500">Leave empty to publish immediately</p>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Featured Post</span>
                                <span class="text-xs text-neutral-500">Highlight on homepage</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Allow Comments</span>
                                <span class="text-xs text-neutral-500">Enable reader comments</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="allow_comments" value="1" {{ old('allow_comments', true) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Include in Sitemap</span>
                                <span class="text-xs text-neutral-500">Search engines will index this</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="include_in_sitemap" value="1" {{ old('include_in_sitemap', true) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Category</h2>
                        
                        <div>
                            <select id="blog_category_id" name="blog_category_id" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                                <option value="">Uncategorized</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Featured Image</h2>
                        
                        <div id="featured_image_preview" class="hidden">
                            <img src="" alt="Featured image" class="w-full h-48 object-cover rounded-lg mb-3">
                            <button type="button" onclick="removeFeaturedImage()" class="text-sm text-red-600 hover:text-red-900">Remove Image</button>
                        </div>

                        <div id="featured_image_placeholder" class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-neutral-300 rounded-lg hover:bg-neutral-50 cursor-pointer">
                            <svg class="h-12 w-12 text-neutral-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-neutral-600 mb-1">Click to select image</p>
                            <p class="text-xs text-neutral-400">Or use media library</p>
                        </div>

                        <input type="hidden" name="featured_image" id="featured_image" value="{{ old('featured_image') }}">
                        
                        <button type="button" onclick="openMediaLibrary('featured')" class="w-full px-4 py-2 text-sm font-medium text-leather-900 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50">
                            Choose from Media Library
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Media Selector Modal -->
    <div id="mediaSelectorModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeMediaSelectorModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-white px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Select Media</h3>
                        <p class="text-sm text-gray-500 mt-1">Choose an image from your library.</p>
                    </div>
                    <button onclick="closeMediaSelectorModal()" class="text-gray-400 hover:text-gray-500 transition-colors p-2 rounded-full hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="bg-gray-50/50 px-6 py-6 h-[65vh] overflow-y-auto custom-scrollbar">
                     <div id="mediaSelectorGrid" class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-8 gap-3">
                         <!-- Media Items will be injected here -->
                     </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Custom Editor Functions
        function execCmd(command, value = null) {
            document.execCommand(command, false, value);
            updateContentInput();
            document.getElementById('editor').focus();
        }

        function createLink() {
            const url = prompt("Enter the link URL:", "http://");
            if (url) {
                execCmd('createLink', url);
            }
        }

        function insertImage() {
            openMediaLibrary('editor', function(url, meta) {
                const editor = document.getElementById('editor');
                editor.focus();
                document.execCommand('insertImage', false, url);
                updateContentInput();
            });
        }

        function updateContentInput() {
            const editor = document.getElementById('editor');
            const content = editor.innerHTML;
            document.getElementById('contentInput').value = content;
            
            // Updates for counts and SEO
            const text = editor.innerText || editor.textContent;
            document.getElementById('wordCount').innerText = text.trim().split(/\s+/).filter(w => w.length > 0).length;
            document.getElementById('charCount').innerText = text.length;
            
            analyzeSEO();
        }

        // SEO Analysis Functions
        function analyzeSEO() {
            const title = document.getElementById('title').value;
            const content = document.getElementById('editor').innerText;
            const metaTitle = document.getElementById('meta_title').value;
            const metaDesc = document.getElementById('meta_description').value;
            
            const results = [];
            let score = 0;
            let maxScore = 5; // Total criteria

            // 1. Title Analysis
            if (title.length >= 30 && title.length <= 60) {
                results.push({ type: 'success', msg: 'Blog Title length is good.' });
                score++;
            } else if (title.length < 30) {
                results.push({ type: 'warning', msg: 'Blog Title is too short (aim for 30+ chars).' });
            } else {
                results.push({ type: 'warning', msg: 'Blog Title is too long (aim for < 60 chars).' });
            }

            // 2. Content Length
            const wordCount = content.trim().split(/\s+/).filter(w => w.length > 0).length;
            if (wordCount >= 300) {
                results.push({ type: 'success', msg: 'Content length is good (> 300 words).' });
                score++;
            } else {
                results.push({ type: 'error', msg: `Content is too short (${wordCount} words). Aim for 300+.` });
            }

            // 3. Meta Title Analysis
            document.getElementById('metaTitleCount').innerText = `${metaTitle.length} / 60 chars`;
            if (metaTitle.length > 0 && metaTitle.length <= 60) {
                results.push({ type: 'success', msg: 'Meta Title length is good.' });
                score++;
            } else if (metaTitle.length > 60) {
                results.push({ type: 'error', msg: 'Meta Title is too long.' });
            } else {
                 results.push({ type: 'warning', msg: 'Meta Title is missing.' });
            }

            // 4. Meta Description Analysis
            document.getElementById('metaDescCount').innerText = `${metaDesc.length} / 160 chars`;
            if (metaDesc.length >= 120 && metaDesc.length <= 160) {
                results.push({ type: 'success', msg: 'Meta Description length is good.' });
                score++;
            } else if (metaDesc.length < 120 && metaDesc.length > 0) {
                results.push({ type: 'warning', msg: 'Meta Description is short.' });
            } else if (metaDesc.length > 160) {
                 results.push({ type: 'error', msg: 'Meta Description is too long.' });
            } else {
                 results.push({ type: 'warning', msg: 'Meta Description is missing.' });
            }

            // 5. Keyword in Content (Basic check for Title words in content)
            const titleWords = title.toLowerCase().split(/\s+/).filter(w => w.length > 3);
            if (titleWords.length > 0) {
                const firstPara = content.substring(0, 500).toLowerCase();
                const found = titleWords.some(w => firstPara.includes(w));
                if (found) {
                     results.push({ type: 'success', msg: 'Keyphrase appears in the first paragraph.' });
                     score++;
                } else {
                     results.push({ type: 'warning', msg: 'Keyphrase not found in the beginning of content.' });
                }
            }

            // Render Results
            const list = document.getElementById('seoAnalysisList');
            list.innerHTML = '';
            results.forEach(res => {
                const color = res.type === 'success' ? 'bg-green-500' : (res.type === 'warning' ? 'bg-yellow-500' : 'bg-red-500');
                const text = res.type === 'success' ? 'text-green-700' : (res.type === 'warning' ? 'text-yellow-700' : 'text-red-700');
                list.innerHTML += `<li class="${text} flex items-center"><span class="w-2 h-2 ${color} rounded-full mr-2"></span>${res.msg}</li>`;
            });

            // Update Score Badge
            const scoreEl = document.getElementById('seoScore');
            if (score === maxScore) {
                scoreEl.className = 'px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800';
                scoreEl.innerText = 'Excellent';
            } else if (score >= 3) {
                 scoreEl.className = 'px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800';
                 scoreEl.innerText = 'Good';
            } else {
                 scoreEl.className = 'px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800';
                 scoreEl.innerText = 'Needs Improvement';
            }
        }

        // Event Listeners for SEO Refresh
        document.getElementById('editor').addEventListener('keyup', updateContentInput);
        document.getElementById('editor').addEventListener('blur', updateContentInput);
        document.getElementById('title').addEventListener('input', analyzeSEO);
        document.getElementById('meta_title').addEventListener('input', analyzeSEO);
        document.getElementById('meta_description').addEventListener('input', analyzeSEO);

        // Media Library Handler
        let mediaModalTarget = null;
        let mediaModalCallback = null;

        function openMediaLibrary(target, callback) {
            mediaModalTarget = target;
            mediaModalCallback = callback;
            document.getElementById('mediaSelectorModal').classList.remove('hidden');
            loadMediaItems();
        }

        function closeMediaSelectorModal() {
            document.getElementById('mediaSelectorModal').classList.add('hidden');
            mediaModalTarget = null;
            mediaModalCallback = null;
        }

        function loadMediaItems(page = 1) {
            const grid = document.getElementById('mediaSelectorGrid');
            grid.innerHTML = '<div class="col-span-full text-center py-10"><svg class="animate-spin h-8 w-8 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
            
            fetch(`{{ route('admin.media.index') }}?page=${page}&type=image`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                grid.innerHTML = '';
                if (data.data.length === 0) {
                    grid.innerHTML = '<div class="col-span-full text-center py-10 text-gray-500">No images found.</div>';
                    return;
                }

                data.data.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'relative group aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all border border-gray-200';
                    div.onclick = () => selectMediaItem(item);
                    div.innerHTML = `
                        <img src="${item.url}" alt="${item.alt_text || item.file_name}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity"></div>
                    `;
                    grid.appendChild(div);
                });
            })
            .catch(err => {
                console.error('Error loading media:', err);
                grid.innerHTML = '<div class="col-span-full text-center py-10 text-red-500">Failed to load media.</div>';
            });
        }

        function selectMediaItem(item) {
            if (mediaModalTarget === 'featured') {
                setFeaturedImage(item.url);
            } else if (mediaModalTarget === 'editor' && mediaModalCallback) {
                mediaModalCallback(item.url, { title: item.alt_text });
            }
            closeMediaSelectorModal();
        }

        function setFeaturedImage(url) {
            document.getElementById('featured_image').value = url;
            document.getElementById('featured_image_preview').querySelector('img').src = url;
            document.getElementById('featured_image_preview').classList.remove('hidden');
            document.getElementById('featured_image_placeholder').classList.add('hidden');
        }

        function removeFeaturedImage() {
            document.getElementById('featured_image').value = '';
            document.getElementById('featured_image_preview').classList.add('hidden');
            document.getElementById('featured_image_placeholder').classList.remove('hidden');
        }

        // Auto-generate slug from title
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        function generateSlug(text) {
             return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }

        titleInput.addEventListener('keyup', function() {
            if (!slugInput.value || slugInput.getAttribute('data-touched') !== 'true') {
                 slugInput.value = generateSlug(this.value);
            }
        });

        titleInput.addEventListener('blur', function() {
             if (!slugInput.value) {
                 slugInput.value = generateSlug(this.value);
             }
        });
        
        // Track if user manually edited slug
        slugInput.addEventListener('input', function() {
            this.setAttribute('data-touched', 'true');
        });
    </script>
@endsection
