@extends('layouts.admin')

@section('title', 'Edit Product: ' . $product->name)

@section('content')
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        class="ajax-form pb-20">
        @csrf
        @method('PUT')
        <div id="removed-images-container"></div>

        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Edit Product</h1>
                <p class="text-sm text-neutral-500">Update product information.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.products.index') }}"
                    class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                    Cancel
                </a>
                <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                    class="px-4 py-2 text-sm font-medium text-gold-600 bg-white border border-gold-300 rounded-lg hover:bg-gold-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all transform hover:-translate-y-0.5 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Product
                </a>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all transform hover:-translate-y-0.5">
                    Update Product
                </button>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Main Grid Layout -->
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
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-neutral-700 mb-2">URL Slug</label>
                                <div class="flex rounded-lg shadow-sm">
                                    <span
                                        class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
                                        {{ config('app.url') }}/product/
                                    </span>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}"
                                        class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-lg focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300">
                                </div>
                            </div>

                            <div>
                                <x-rich-text-editor name="description" :value="old('description', $product->description)"
                                    label="Description" height="250px" />
                            </div>

                            <div>
                                <label for="daraz_url" class="block text-sm font-medium text-neutral-700 mb-2">Daraz URL
                                    <span class="text-neutral-400 font-normal">(Optional)</span></label>
                                <input type="url" name="daraz_url" id="daraz_url"
                                    value="{{ old('daraz_url', $product->daraz_url) }}"
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
                            <!-- All Product Images -->
                            @if($product->image || ($product->images && count($product->images) > 0))
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-3">Product Images</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-3">
                                        <!-- Main Image with Badge -->
                                        @if($product->image)
                                            <div class="relative w-28 h-28 group">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                    class="w-full h-full object-cover rounded-xl shadow-md group-hover:shadow-2xl cursor-pointer transition-all duration-300 transform group-hover:scale-105 ring-2 ring-gold-400"
                                                    onclick="showImagePreview('{{ $product->image_url }}')">
                                                <span
                                                    class="absolute top-0 left-0 bg-green-600 text-white text-xs font-semibold px-2.5 py-1.5 rounded-br-lg shadow-lg z-20">Main</span>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endif

                            <!-- Main Image Upload -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-neutral-700 mb-2">{{ $product->image ? 'Replace Main Image' : 'Main Image' }}</label>

                                <!-- New Image Preview -->
                                <div id="main-image-preview-container" class="hidden mb-3 relative w-24 h-24">
                                    <img id="main-image-preview" src=""
                                        class="w-full h-full object-cover rounded-lg border border-neutral-200">
                                    <button type="button" id="remove-main-image-btn"
                                        class="absolute top-0 right-0 bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 shadow-lg hover:shadow-xl transition-all transform hover:scale-110 z-10">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                @if($product->image)
                                    <!-- Simple file input for replacement -->
                                    <div
                                        class="mt-1 border-2 border-dashed border-neutral-300 rounded-xl p-6 hover:border-gold-400 hover:bg-gold-50/30 transition-all duration-300">
                                        <input id="image" name="image" type="file"
                                            class="block w-full text-sm text-neutral-700 file:mr-4 file:py-2.5 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-gold-500 file:to-gold-600 file:text-white hover:file:from-gold-600 hover:file:to-gold-700 file:cursor-pointer cursor-pointer file:shadow-md hover:file:shadow-lg file:transition-all"
                                            accept="image/*">
                                        <p class="mt-3 text-xs text-neutral-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                @else
                                    <!-- Full upload area for new products -->
                                    <div id="main-image-upload-area"
                                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-xl hover:bg-neutral-50 transition-colors cursor-pointer relative">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none"
                                                viewBox="0 0 48 48">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-neutral-600 justify-center">
                                                <label for="image"
                                                    class="relative cursor-pointer bg-white rounded-md font-medium text-gold-600 hover:text-gold-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-gold-500">
                                                    <span>Upload a file</span>
                                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-neutral-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                @endif
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Product Variants Card -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden" x-data="{
                                                                                                                        colors: {{ $product->colors->map(function ($c) {
        return [
            'id' => $c->id,
            'name' => $c->name,
            'color_code' => $c->color_code,
            'image_url' => $c->getImageUrlAttribute(),
            'images' => $c->images ?? [], // Raw paths for form submission
            'images_display' => $c->getImagesUrlsAttribute(), // URLs for display only
            'removed_images' => [], // Init
            'new_images' => [],  // Init
            'sizes' => $c->variants->map(function ($v) {
                return [
                    'id' => $v->id,
                    'name' => $v->size,
                    'stock' => $v->stock,
                    'price' => $v->price,
                    'sale_price' => $v->sale_price,
                    'sku' => $v->sku
                ];
            })
        ];
    })->toJson() }},
                                                                                                                        addColor() {
                                                                                                                            this.colors.push({
                                                                                                                                id: null,
                                                                                                                                name: '',
                                                                                                                                color_code: '#000000',
                                                                                                                                remove_image: 0,
                                                                                                                                image_url: null,
                                                                                                                                images: [],
                                                                                                                                removed_images: [],
                                                                                                                                new_images: [],
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
                                                                                                                                sku: '',
                                                                                                                            stock: 0,
                                                                                                                            price: '',
                                                                                                                            sale_price: '',
                                                                                                                            sku: ''
                                                                                                                        });
                                                                                                                        },
                                                                                                                        removeSize(colorIndex, sizeIndex) {
                                                                                                                            this.colors[colorIndex].sizes.splice(sizeIndex, 1);
                                                                                                                        },

                                                                                                                    handleFileSelect(event, colorIndex) {
                                                                                                                        const files = event.target.files;
                                                                                                                        if (!files.length) return;

                                                                                                                        // Initialize new_images if undefined
                                                                                                                        if (!this.colors[colorIndex].new_images) {
                                                                                                                            this.colors[colorIndex].new_images = [];
                                                                                                                        }

                                                                                                                        Array.from(files).forEach(file => {
                                                                                                                            const reader = new FileReader();
                                                                                                                            reader.onload = (e) => {
                                                                                                                                this.colors[colorIndex].new_images.push(e.target.result);
                                                                                                                            };
                                                                                                                            reader.readAsDataURL(file);
                                                                                                                        });
                                                                                                                    },
                                                                                                                    removeVariantImage(colorIndex, imageIndex, isExisting = true) {
                                                                                                                        if (isExisting) {
                                                                                                                            // Get the path (not URL) for removal tracking
                                                                                                                            const imagePath = this.colors[colorIndex].images[imageIndex];
                                                                                                                            if (!this.colors[colorIndex].removed_images) {
                                                                                                                                this.colors[colorIndex].removed_images = [];
                                                                                                                            }
                                                                                                                            this.colors[colorIndex].removed_images.push(imagePath);

                                                                                                                            // Remove from both arrays
                                                                                                                            this.colors[colorIndex].images.splice(imageIndex, 1);
                                                                                                                            this.colors[colorIndex].images_display.splice(imageIndex, 1);
                                                                                                                        }
                                                                                                                    },
                                                                                                                    removeNewVariantImage(colorIndex, imageIndex) {
                                                                                                                        this.colors[colorIndex].new_images.splice(imageIndex, 1);
                                                                                                                    },
                                                                                                                    // Drag and drop for reordering
                                                                                                                    dragStart(event, colorIndex, imageIndex, isNew = false) {
                                                                                                                        event.dataTransfer.effectAllowed = 'move';
                                                                                                                        event.dataTransfer.setData('colorIndex', colorIndex);
                                                                                                                        event.dataTransfer.setData('imageIndex', imageIndex);
                                                                                                                        event.dataTransfer.setData('isNew', isNew);
                                                                                                                    },
                                                                                                                    dragOver(event) {
                                                                                                                        event.preventDefault();
                                                                                                                        event.dataTransfer.dropEffect = 'move';
                                                                                                                    },
                                                                                                                    drop(event, colorIndex, targetIndex, isNewTarget = false) {
                                                                                                                        event.preventDefault();
                                                                                                                        const sourceColorIndex = parseInt(event.dataTransfer.getData('colorIndex'));
                                                                                                                        const sourceIndex = parseInt(event.dataTransfer.getData('imageIndex'));
                                                                                                                        const isNew = event.dataTransfer.getData('isNew') === 'true';

                                                                                                                        // Only allow reordering within same color and same type (existing/new)
                                                                                                                        if (sourceColorIndex !== colorIndex || isNew !== isNewTarget) return;

                                                                                                                        if (isNew) {
                                                                                                                            // Reorder new images
                                                                                                                            const [movedItem] = this.colors[colorIndex].new_images.splice(sourceIndex, 1);
                                                                                                                            this.colors[colorIndex].new_images.splice(targetIndex, 0, movedItem);
                                                                                                                        } else {
                                                                                                                            // Reorder existing images (both arrays)
                                                                                                                            const [movedPath] = this.colors[colorIndex].images.splice(sourceIndex, 1);
                                                                                                                            const [movedUrl] = this.colors[colorIndex].images_display.splice(sourceIndex, 1);
                                                                                                                            this.colors[colorIndex].images.splice(targetIndex, 0, movedPath);
                                                                                                                            this.colors[colorIndex].images_display.splice(targetIndex, 0, movedUrl);
                                                                                                                        }
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
                                <div
                                    class="bg-gradient-to-br from-white to-neutral-50 rounded-xl p-8 border-2 border-neutral-200 hover:border-gold-300 transition-all duration-300 shadow-sm hover:shadow-md relative">
                                    <!-- Delete Button -->
                                    <button type="button" @click="removeColor(index)"
                                        class="absolute top-4 right-4 p-2 text-neutral-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <!-- Color Badge -->
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="w-10 h-10 rounded-lg shadow-md border-2 border-white"
                                            :style="'background-color: ' + color.color_code"></div>
                                        <div>
                                            <h3 class="text-lg font-bold text-leather-900"
                                                x-text="color.name || 'New Color'"></h3>
                                            <p class="text-xs text-neutral-500" x-text="color.color_code"></p>
                                        </div>
                                    </div>

                                    <!-- Hidden ID Input -->
                                    <input type="hidden" :name="'colors[' + index + '][id]'" x-model="color.id">

                                    <!-- Color Details Grid -->
                                    <div class="bg-white rounded-lg p-6 mb-6 border border-neutral-100">
                                        <h4 class="text-sm font-semibold text-neutral-700 mb-4 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gold-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                            </svg>
                                            Color Information
                                        </h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-neutral-600 mb-2">Color Name
                                                    <span class="text-red-500">*</span></label>
                                                <input type="text" :name="'colors[' + index + '][name]'"
                                                    x-model="color.name"
                                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm py-2.5 px-3"
                                                    placeholder="e.g. Midnight Blue" required>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-neutral-600 mb-2">Color
                                                    Code</label>
                                                <div class="flex items-center gap-2">
                                                    <input type="color" :name="'colors[' + index + '][color_code]'"
                                                        x-model="color.color_code"
                                                        class="h-10 w-10 p-0 border-2 border-neutral-200 rounded-lg overflow-hidden cursor-pointer shadow-sm">
                                                    <input type="text" :name="'colors[' + index + '][color_code]'"
                                                        x-model="color.color_code"
                                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm py-2.5 px-3"
                                                        placeholder="#000000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Variant Images Section -->
                                    <div class="bg-white rounded-lg p-6 border border-neutral-100">
                                        <h4 class="text-sm font-semibold text-neutral-700 mb-4 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gold-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Variant Images
                                            <span class="text-xs font-normal text-neutral-500">(Max 4)</span>
                                        </h4>
                                        <div class="flex flex-wrap gap-3">
                                            <!-- Existing Images -->
                                            <template x-for="(img, imgIndex) in color.images_display"
                                                :key="'existing-' + imgIndex">
                                                <div class="relative w-20 h-20 group cursor-move" draggable="true"
                                                    @dragstart="dragStart($event, index, imgIndex, false)"
                                                    @dragover="dragOver($event)"
                                                    @drop="drop($event, index, imgIndex, false)">
                                                    <img :src="img"
                                                        class="w-full h-full object-cover rounded-lg border-2 border-neutral-200 shadow-sm group-hover:shadow-md transition-all pointer-events-none">
                                                    <button type="button" @click="removeVariantImage(index, imgIndex, true)"
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 hover:scale-110 transition-all z-10">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>

                                            <!-- Hidden inputs for existing images (only non-deleted ones) -->
                                            <template x-for="(img, imgIndex) in color.images" :key="'hidden-' + imgIndex">
                                                <input type="hidden" :name="'colors[' + index + '][existing_images][]'"
                                                    :value="img">
                                            </template>

                                            <!-- New Image Previews -->
                                            <template x-for="(img, imgIndex) in color.new_images" :key="'new-' + imgIndex">
                                                <div class="relative w-20 h-20 group cursor-move" draggable="true"
                                                    @dragstart="dragStart($event, index, imgIndex, true)"
                                                    @dragover="dragOver($event)"
                                                    @drop="drop($event, index, imgIndex, true)">
                                                    <img :src="img"
                                                        class="w-full h-full object-cover rounded-lg border-2 border-gold-200 shadow-sm pointer-events-none">
                                                    <div
                                                        class="absolute top-1 right-1 bg-gold-500 text-white text-xs px-1.5 py-0.5 rounded-full font-semibold pointer-events-none">
                                                        New</div>
                                                    <button type="button" @click="removeNewVariantImage(index, imgIndex)"
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 hover:scale-110 transition-all z-10">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>

                                            <!-- Upload Button -->
                                            <label
                                                class="w-20 h-20 flex flex-col items-center justify-center border-2 border-dashed border-neutral-300 rounded-lg hover:border-gold-400 hover:bg-gold-50 cursor-pointer bg-white transition-all group">
                                                <svg class="w-6 h-6 text-neutral-400 group-hover:text-gold-600 transition-colors"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                <span
                                                    class="text-xs text-neutral-500 mt-1 group-hover:text-gold-600">Add</span>
                                                <input type="file" multiple accept="image/*"
                                                    :name="'colors[' + index + '][images][]'"
                                                    @change="handleFileSelect($event, index)" class="hidden">
                                            </label>
                                        </div>

                                        <!-- Hidden Inputs for Removed Images -->
                                        <template x-for="(remImg, remIndex) in color.removed_images" :key="remIndex">
                                            <input type="hidden" :name="'colors[' + index + '][removed_images][]'"
                                                :value="remImg">
                                        </template>
                                    </div>

                                    <!-- Nested Sizes -->
                                    <div class="bg-white rounded-lg border border-neutral-100 p-6">
                                        <div class="flex items-center justify-between mb-5">
                                            <h4 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gold-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                Sizes & Inventory
                                            </h4>
                                            <button type="button" @click="addSize(index)"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gold-700 bg-gold-50 hover:bg-gold-100 rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Add Size
                                            </button>
                                        </div>

                                        <div class="space-y-3">
                                            <template x-for="(size, sIndex) in color.sizes" :key="sIndex">
                                                <div
                                                    class="bg-neutral-50 p-5 rounded-lg border border-neutral-200 hover:border-gold-200 transition-all">
                                                    <!-- Hidden ID Input -->
                                                    <input type="hidden"
                                                        :name="'colors[' + index + '][sizes][' + sIndex + '][id]'"
                                                        x-model="size.id">

                                                    <div class="flex gap-4">
                                                        <div class="flex-1">
                                                            <div
                                                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-semibold text-neutral-600 mb-1.5">
                                                                        Size Name <span class="text-red-500">*</span>
                                                                    </label>
                                                                    <input type="text"
                                                                        :name="'colors[' + index + '][sizes][' + sIndex + '][name]'"
                                                                        x-model="size.name"
                                                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm py-2 px-3"
                                                                        placeholder="S, M, L, XL" required>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-semibold text-neutral-600 mb-1.5">
                                                                        Stock <span class="text-red-500">*</span>
                                                                    </label>
                                                                    <input type="number"
                                                                        :name="'colors[' + index + '][sizes][' + sIndex + '][stock]'"
                                                                        x-model="size.stock"
                                                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm py-2 px-3"
                                                                        placeholder="10" min="0" required>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-semibold text-neutral-600 mb-1.5">
                                                                        Price (Rs.)
                                                                    </label>
                                                                    <input type="number" step="0.01"
                                                                        :name="'colors[' + index + '][sizes][' + sIndex + '][price]'"
                                                                        x-model="size.price"
                                                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm py-2 px-3"
                                                                        placeholder="Override base price" min="0">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-semibold text-neutral-600 mb-1.5">
                                                                        Sale Price (Rs.)
                                                                    </label>
                                                                    <input type="number" step="0.01"
                                                                        :name="'colors[' + index + '][sizes][' + sIndex + '][sale_price]'"
                                                                        x-model="size.sale_price"
                                                                        class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm py-2 px-3"
                                                                        placeholder="Discounted price" min="0">
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-semibold text-neutral-600 mb-1.5">
                                                                    SKU <span
                                                                        class="text-neutral-400 font-normal">(Optional)</span>
                                                                </label>
                                                                <input type="text"
                                                                    :name="'colors[' + index + '][sizes][' + sIndex + '][sku]'"
                                                                    x-model="size.sku"
                                                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 text-sm py-2 px-3"
                                                                    placeholder="e.g., BELT-BLK-M">
                                                            </div>
                                                        </div>

                                                        <!-- Delete Button -->
                                                        <button type="button" @click="removeSize(index, sIndex)"
                                                            class="p-2 h-fit text-neutral-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                            title="Remove Size">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>

                                            <div x-show="color.sizes.length === 0"
                                                class="text-center py-8 border-2 border-dashed border-neutral-200 rounded-lg">
                                                <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                <p class="text-sm text-neutral-500 mb-2">No sizes added yet</p>
                                                <button type="button" @click="addSize(index)"
                                                    class="text-gold-600 font-medium hover:text-gold-700 text-sm">Add your
                                                    first size</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="colors.length === 0"
                                class="text-center py-12 border-2 border-dashed border-neutral-200 rounded-xl bg-neutral-50">
                                <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                <p class="text-neutral-500 mb-3">No color variants added</p>
                                <button type="button" @click="addColor()"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gold-700 bg-gold-50 hover:bg-gold-100 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add your first color variant
                                </button>
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
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="sr-only peer">
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
                                    <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="sr-only peer">
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
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="deal_id" class="block text-sm font-medium text-neutral-700 mb-2">Active Deal</label>
                            <select id="deal_id" name="deal_id"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                                <option value="">None</option>
                                @foreach($deals as $deal)
                                    <option value="{{ $deal->id }}" {{ old('deal_id', $product->deal_id) == $deal->id ? 'selected' : '' }}>
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
                            <input type="text" name="meta_title" id="meta_title"
                                value="{{ old('meta_title', $product->meta_title) }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-neutral-700 mb-2">Meta
                                Description</label>
                            <textarea id="meta_description" name="meta_description" rows="4"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">{{ old('meta_description', $product->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal"
        class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4"
        onclick="closeImagePreview()">
        <div class="relative max-w-7xl max-h-screen">
            <button onclick="closeImagePreview()"
                class="absolute top-0 right-0 bg-red-600 hover:bg-red-700 text-white rounded-full p-2 shadow-lg hover:shadow-xl transition-all transform hover:scale-110 z-10">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-screen object-contain rounded-lg shadow-2xl"
                onclick="event.stopPropagation()">
        </div>
    </div>

    <script>
        function showImagePreview(imageUrl) {
            const modal = document.getElementById('imagePreviewModal');
            const previewImg = document.getElementById('previewImage');
            previewImg.src = imageUrl;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImagePreview() {
            const modal = document.getElementById('imagePreviewModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeImagePreview();
            }
        });

        // Main Image Preview Logic
        const mainImageInput = document.getElementById('image');
        const mainImagePreviewContainer = document.getElementById('main-image-preview-container');
        const mainImagePreview = document.getElementById('main-image-preview');
        const removeMainImageBtn = document.getElementById('remove-main-image-btn');
        const mainImageUploadArea = document.getElementById('main-image-upload-area');

        mainImageInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    mainImagePreview.src = e.target.result;
                    mainImagePreviewContainer.classList.remove('hidden');
                    // Hide upload area mostly for cleaner UI, or just keep it
                    // Let's keep it accessible but maybe smaller or just below
                }
                reader.readAsDataURL(file);
            }
        });

        removeMainImageBtn.addEventListener('click', function () {
            mainImageInput.value = ''; // Clear input
            mainImagePreview.src = '';
            mainImagePreviewContainer.classList.add('hidden');
        });

        // Gallery Management Logic
        const galleryTrigger = document.getElementById('gallery_trigger');
        const galleryInput = document.getElementById('images'); // The actual input
        const galleryPreviewsContainer = document.getElementById('new-gallery-previews');

        // DataTransfer object to hold files from multiple selections
        const galleryFiles = new DataTransfer();

        galleryTrigger.addEventListener('change', function (e) {
            const newFiles = Array.from(e.target.files);

            newFiles.forEach(file => {
                // Add to DataTransfer
                galleryFiles.items.add(file);

                // create preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                                                                                                                             <img src="${e.target.result}" class="h-24 w-24 object-cover rounded-lg border border-neutral-200" title="${file.name}">
                                                                                                                             <button type="button" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full p-1 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity" onclick="removeNewGalleryImage('${file.name}', this)">
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

            // Update the actual input
            galleryInput.files = galleryFiles.files;

            // Reset trigger so same file can be selected again if needed (though DataTransfer handles duplication logic if we wanted to prevent it, but simple append is fine)
            galleryTrigger.value = '';
        });

        window.removeNewGalleryImage = function (fileName, btnElement) {
            // Remove from DataTransfer
            const newDataTransfer = new DataTransfer();
            Array.from(galleryFiles.files).forEach(file => {
                if (file.name !== fileName) {
                    newDataTransfer.items.add(file);
                }
            });

            // clear old and assign new
            galleryFiles.items.clear();
            Array.from(newDataTransfer.files).forEach(file => galleryFiles.items.add(file));

            galleryInput.files = galleryFiles.files;

            // Remove UI
            btnElement.closest('.relative').remove();

            if (galleryFiles.files.length === 0) {
                galleryPreviewsContainer.classList.add('hidden');
            }
        };

        window.removeGalleryImage = function (imageUrl, btnElement) {
            if (confirm('Are you sure you want to remove this image?')) {
                const container = document.getElementById('removed-images-container');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'removed_images[]';
                input.value = imageUrl;
                container.appendChild(input);

                btnElement.closest('.relative').remove();
            }
        }

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
    </script>
@endsection