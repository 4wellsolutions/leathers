@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="ajax-form pb-20">
        @csrf

        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Add New Product</h1>
                <p class="text-sm text-neutral-500">Create a new product for your store.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.products.index') }}"
                    class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all transform hover:-translate-y-0.5">
                    Save Product
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Main Content (8 cols) -->
            <div class="lg:col-span-8 space-y-8">

                <!-- Basic Details Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 md:p-8 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 border-b border-neutral-100 pb-4 mb-6">Product
                            Information</h2>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Product
                                    Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4 @error('name') border-red-500 @enderror"
                                    placeholder="e.g. Classic Leather Belt" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-neutral-700 mb-2">URL Slug</label>
                                <div class="flex rounded-lg shadow-sm">
                                    <span
                                        class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
                                        {{ config('app.url') }}/product/
                                    </span>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                        class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-lg focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300 @error('slug') border-red-500 @enderror"
                                        placeholder="classic-leather-belt">
                                </div>
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-rich-text-editor name="description" :value="old('description')" label="Description"
                                    height="250px" />
                            </div>

                            <div>
                                <label for="daraz_url" class="block text-sm font-medium text-neutral-700 mb-2">Daraz URL
                                    <span class="text-neutral-400 font-normal">(Optional)</span></label>
                                <input type="url" name="daraz_url" id="daraz_url" value="{{ old('daraz_url') }}"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4"
                                    placeholder="https://www.daraz.pk/products/...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 md:p-8 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 border-b border-neutral-100 pb-4 mb-6">Product
                            Images</h2>

                        <div class="space-y-6">
                            <!-- Main Image -->
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Main Image</label>
                                <div id="main-image-preview"
                                    class="hidden mb-3 relative w-[200px] h-[200px] border border-neutral-300 rounded-lg overflow-hidden bg-neutral-50 flex items-center justify-center">
                                    <img src="" alt="Preview" class="max-w-full max-h-full object-contain">
                                    <button type="button" onclick="removeMainImage()"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 shadow-md hover:bg-red-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="main-image-upload"
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-xl hover:bg-neutral-50 transition-colors cursor-pointer relative">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-neutral-600 justify-center">
                                            <label for="image"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-gold-600 hover:text-gold-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-gold-500">
                                                <span>Upload a file</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*"
                                                    onchange="previewMainImage(event)">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-neutral-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gallery Images -->
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Gallery Images</label>

                                <div id="gallery-preview" class="hidden grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4"></div>

                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-xl hover:bg-neutral-50 transition-colors cursor-pointer relative"
                                    id="gallery-drop-zone">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div class="flex text-sm text-neutral-600 justify-center">
                                            <label for="gallery_trigger"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-gold-600 hover:text-gold-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-gold-500">
                                                <span>Upload files</span>
                                                <!-- Hidden trigger -->
                                                <input id="gallery_trigger" type="file" class="sr-only" multiple
                                                    accept="image/*">
                                                <!-- Real input -->
                                                <input id="images" name="images[]" type="file" class="hidden" multiple
                                                    accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-neutral-500">Multiple images supported</p>
                                    </div>
                                </div>
                                @error('images')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Variants Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden" x-data="{
                                        colors: [],
                                        addColor() {
                                            this.colors.push({
                                                id: null,
                                                name: '',
                                                color_code: '#000000',
                                                sizes: []
                                            });
                                        },
                                        removeColor(index) {
                                            this.colors.splice(index, 1);
                                        },
                                        addSize(colorIndex) {
                                            this.colors[colorIndex].sizes.push({
                                                id: null,
                                                name: '',
                                                stock: 0,
                                                price: '',
                                                sale_price: '',
                                                sku: ''
                                            });
                                        },
                                        removeSize(colorIndex, sizeIndex) {
                                            this.colors[colorIndex].sizes.splice(sizeIndex, 1);
                                        }
                                    }">
                    <div class="p-6 md:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-neutral-100 pb-4 mb-6">
                            <h2 class="text-lg font-semibold text-leather-900">Product Variants (Colors & Sizes)</h2>
                            <button type="button" @click="addColor()"
                                class="text-sm text-gold-600 hover:text-gold-700 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Color
                            </button>
                        </div>

                        <div class="space-y-8">
                            <template x-for="(color, index) in colors" :key="index">
                                <div class="bg-neutral-50 rounded-lg p-6 border border-neutral-200 relative">
                                    <button type="button" @click="removeColor(index)"
                                        class="absolute top-4 right-4 text-neutral-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-neutral-500 uppercase tracking-wider mb-2">Color
                                                Name</label>
                                            <input type="text" :name="'colors[' + index + '][name]'" x-model="color.name"
                                                class="block w-full rounded-md border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                                placeholder="e.g. Midnight Blue">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-neutral-500 uppercase tracking-wider mb-2">Color
                                                Code</label>
                                            <div class="flex items-center space-x-2">
                                                <input type="color" :name="'colors[' + index + '][color_code]'"
                                                    x-model="color.color_code"
                                                    class="h-9 w-9 p-0 border-0 rounded overflow-hidden cursor-pointer">
                                                <input type="text" :name="'colors[' + index + '][color_code]'"
                                                    x-model="color.color_code"
                                                    class="block w-full rounded-md border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                                    placeholder="#000000">
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-neutral-500 uppercase tracking-wider mb-2">Color
                                                Image</label>
                                            <input type="file" :name="'colors[' + index + '][image]'" accept="image/*"
                                                class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100">
                                        </div>
                                    </div>

                                    <!-- Nested Sizes -->
                                    <div class="bg-white rounded-md border border-neutral-200 p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-sm font-medium text-leather-900">Sizes & Inventory</h4>
                                            <button type="button" @click="addSize(index)"
                                                class="text-xs text-gold-600 hover:text-gold-700 font-medium">+ Add
                                                Size</button>
                                        </div>

                                        <div class="space-y-4">
                                            <template x-for="(size, sIndex) in color.sizes" :key="sIndex">
                                                <div
                                                    class="bg-white p-4 rounded-lg border-2 border-neutral-200 hover:border-gold-300 transition-colors flex gap-4">

                                                    <div class="flex-1">
                                                        <div
                                                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-3">
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-semibold text-neutral-700 mb-1.5">Size
                                                                    Name <span class="text-red-500">*</span></label>
                                                                <input type="text"
                                                                    :name="'colors[' + index + '][sizes][' + sIndex + '][name]'"
                                                                    x-model="size.name"
                                                                    class="block w-full rounded-md border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                                                    placeholder="S, M, L, XL" required>
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-semibold text-neutral-700 mb-1.5">Stock
                                                                    <span class="text-red-500">*</span></label>
                                                                <input type="number"
                                                                    :name="'colors[' + index + '][sizes][' + sIndex + '][stock]'"
                                                                    x-model="size.stock"
                                                                    class="block w-full rounded-md border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                                                    placeholder="10" min="0" required>
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-semibold text-neutral-700 mb-1.5">Price
                                                                    (Rs.)</label>
                                                                <input type="number" step="0.01"
                                                                    :name="'colors[' + index + '][sizes][' + sIndex + '][price]'"
                                                                    x-model="size.price"
                                                                    class="block w-full rounded-md border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                                                    placeholder="Override base price" min="0">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-semibold text-neutral-700 mb-1.5">Sale
                                                                    Price (Rs.)</label>
                                                                <input type="number" step="0.01"
                                                                    :name="'colors[' + index + '][sizes][' + sIndex + '][sale_price]'"
                                                                    x-model="size.sale_price"
                                                                    class="block w-full rounded-md border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                                                    placeholder="Discounted price" min="0">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-semibold text-neutral-700 mb-1.5">SKU
                                                                <span
                                                                    class="text-neutral-400 font-normal">(Optional)</span></label>
                                                            <input type="text"
                                                                :name="'colors[' + index + '][sizes][' + sIndex + '][sku]'"
                                                                x-model="size.sku"
                                                                class="block w-full rounded-md border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm"
                                                                placeholder="e.g., BELT-BLK-M">
                                                        </div>
                                                    </div>

                                                    <!-- Trash Icon on the Right -->
                                                    <button type="button" @click="removeSize(index, sIndex)"
                                                        class="text-neutral-400 hover:text-red-600 transition-colors flex-shrink-0 h-fit"
                                                        title="Remove Size">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>

                                            <div x-show="color.sizes.length === 0"
                                                class="text-center py-4 text-sm text-neutral-400 italic">
                                                No sizes added yet.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="colors.length === 0"
                                class="text-center py-8 border-2 border-dashed border-neutral-200 rounded-lg">
                                <p class="text-neutral-500">No color variants added.</p>
                                <button type="button" @click="addColor()"
                                    class="text-gold-600 font-medium hover:text-gold-700 mt-2">Add your first color
                                    variant</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-8">

                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Status</h2>

                        <label class="flex items-center justify-between cursor-pointer group">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Active Status</span>
                                <span class="text-xs text-neutral-500">Visible on store</span>
                            </div>
                            <div class="relative inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600">
                                </div>
                            </div>
                        </label>

                        <div class="pt-4 border-t border-neutral-100">
                            <label class="flex items-center justify-between cursor-pointer group">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-neutral-900">Featured</span>
                                    <span class="text-xs text-neutral-500">Show in highlights</span>
                                </div>
                                <div class="relative inline-flex items-center">
                                    <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Organization Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">Organization</h2>

                        <div>
                            <label for="category_id"
                                class="block text-sm font-medium text-neutral-700 mb-2">Category</label>
                            <select id="category_id" name="category_id"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="deal_id" class="block text-sm font-medium text-neutral-700 mb-2">Active Deal</label>
                            <select id="deal_id" name="deal_id"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                                <option value="">None</option>
                                @foreach($deals as $deal)
                                    <option value="{{ $deal->id }}" {{ old('deal_id') == $deal->id ? 'selected' : '' }}>
                                        {{ $deal->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SEO Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-leather-900 mb-4">SEO</h2>

                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-neutral-700 mb-2">Meta
                                Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-neutral-700 mb-2">Meta
                                Description</label>
                            <textarea id="meta_description" name="meta_description" rows="4"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <script>
        // Auto-generate slug from title
        const titleInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        let manuallyEdited = false;

        // Track if user manually edits the slug
        slugInput.addEventListener('input', function () {
            manuallyEdited = true;
        });

        // Auto-generate slug when title changes
        titleInput.addEventListener('input', function () {
            if (!manuallyEdited) {
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-')  // Replace spaces with hyphens
                    .replace(/-+/g, '-')   // Replace multiple hyphens with single
                    .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens

                slugInput.value = slug;
            }
        });

        // Allow user to reset to auto-generation
        slugInput.addEventListener('focus', function () {
            if (this.value === '') {
                manuallyEdited = false;
            }
        });

        // Preview main image
        function previewMainImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.querySelector('#main-image-preview img').src = e.target.result;
                    document.getElementById('main-image-preview').classList.remove('hidden');
                    document.getElementById('main-image-upload').classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Remove main image
        function removeMainImage() {
            document.getElementById('image').value = '';
            document.getElementById('main-image-preview').classList.add('hidden');
            document.getElementById('main-image-upload').classList.remove('hidden');
        }

        // Gallery Management Logic (DataTransfer)
        const galleryTrigger = document.getElementById('gallery_trigger');
        const galleryInput = document.getElementById('images');
        const galleryPreviewsContainer = document.getElementById('gallery-preview');
        const galleryFiles = new DataTransfer();

        galleryTrigger.addEventListener('change', function (e) {
            const newFiles = Array.from(e.target.files);

            newFiles.forEach(file => {
                galleryFiles.items.add(file);

                const reader = new FileReader();
                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                                             <img src="${e.target.result}" class="h-24 w-24 object-cover rounded-lg border border-neutral-200" title="${file.name}">
                                             <button type="button" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full p-1 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity" onclick="removeGalleryImage('${file.name}', this)">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        `;
                    galleryPreviewsContainer.appendChild(div);
                    galleryPreviewsContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            });

            galleryInput.files = galleryFiles.files;
            galleryTrigger.value = '';
        });

        window.removeGalleryImage = function (fileName, btnElement) {
            const newDataTransfer = new DataTransfer();
            Array.from(galleryFiles.files).forEach(file => {
                if (file.name !== fileName) {
                    newDataTransfer.items.add(file);
                }
            });

            galleryFiles.items.clear();
            Array.from(newDataTransfer.files).forEach(file => galleryFiles.items.add(file));

            galleryInput.files = galleryFiles.files;
            btnElement.closest('.relative').remove();

            if (galleryFiles.files.length === 0) {
                galleryPreviewsContainer.classList.add('hidden');
            }
        };
    </script>
@endsection