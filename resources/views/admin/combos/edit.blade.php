@extends('layouts.admin')

@section('title', 'Edit Combo: ' . $combo->name)

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('admin.combos.update', $combo->id) }}" method="POST"
            class="space-y-8 divide-y divide-neutral-200 p-6">
            @csrf
            @method('PUT')

            <div class="space-y-8 divide-y divide-neutral-200">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-leather-900">Combo Information</h3>
                    <p class="mt-1 text-sm text-neutral-500">Edit combo details.</p>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-leather-700">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name', $combo->name) }}"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md"
                                    required>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="slug" class="block text-sm font-medium text-leather-700">Slug</label>
                            <div class="mt-1">
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $combo->slug) }}"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                                <p class="mt-1 text-xs text-neutral-500">Leave empty to auto-generate from name</p>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium text-leather-700">Description</label>
                            <div class="mt-1">
                                <textarea id="description" name="description" rows="3"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border border-neutral-300 rounded-md">{{ old('description', $combo->description) }}</textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="price" class="block text-sm font-medium text-leather-700">Price</label>
                            <div class="mt-1">
                                <input type="number" name="price" id="price" value="{{ old('price', $combo->price) }}"
                                    step="0.01"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md"
                                    required>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="start_date" class="block text-sm font-medium text-leather-700">Start Date</label>
                            <div class="mt-1">
                                <input type="datetime-local" name="start_date" id="start_date"
                                    value="{{ old('start_date', $combo->start_date ? $combo->start_date->format('Y-m-d\TH:i') : '') }}"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="end_date" class="block text-sm font-medium text-leather-700">End Date</label>
                            <div class="mt-1">
                                <input type="datetime-local" name="end_date" id="end_date"
                                    value="{{ old('end_date', $combo->end_date ? $combo->end_date->format('Y-m-d\TH:i') : '') }}"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $combo->is_active) ? 'checked' : '' }}
                                        class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-neutral-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_active" class="font-medium text-leather-700">Active</label>
                                    <p class="text-neutral-500">Enable or disable this combo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8">
                    <h3 class="text-lg leading-6 font-medium text-leather-900">Combo Products</h3>
                    <p class="mt-1 text-sm text-neutral-500">Select products to include in this combo.</p>

                    <div class="mt-6 space-y-4">
                        @foreach($products as $product)
                            @php
                                $comboItem = $combo->items->where('product_id', $product->id)->first();
                            @endphp
                            <div class="flex items-center justify-between border-b border-neutral-200 pb-4">
                                <div class="flex items-center">
                                    <input id="product_{{ $product->id }}" name="products[]" value="{{ $product->id }}"
                                        type="checkbox" {{ $comboItem ? 'checked' : '' }}
                                        class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-neutral-300 rounded">
                                    
                                    <div class="ml-3 flex items-center">
                                        @if($product->image)
                                            <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset($product->image) }}')">
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                                     class="h-10 w-10 rounded-md object-cover border border-neutral-200 transition-transform hover:scale-105">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity rounded-md"></div>
                                            </div>
                                        @else
                                            <div class="h-10 w-10 rounded-md bg-neutral-100 border border-neutral-200 flex items-center justify-center text-neutral-400">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <label for="product_{{ $product->id }}" class="ml-3 block text-sm font-medium text-leather-700">
                                            {{ $product->name }} <span class="text-neutral-500">(Rs. {{ number_format($product->price) }})</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <label for="quantity_{{ $product->id }}" class="mr-2 text-sm text-neutral-500">Qty:</label>
                                    <input type="number" name="quantities[{{ $product->id }}]" id="quantity_{{ $product->id }}"
                                        value="{{ $comboItem ? $comboItem->quantity : 1 }}" min="1"
                                        class="w-16 shadow-sm focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300 rounded-md">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <a href="{{ route('admin.combos.index') }}"
                        class="bg-white py-2 px-4 border border-neutral-300 rounded-md shadow-sm text-sm font-medium text-leather-700 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">Cancel</a>
                    <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">Update
                        Combo</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const nameInput = document.getElementById('name');
                const slugInput = document.getElementById('slug');

                if (nameInput && slugInput) {
                    nameInput.addEventListener('input', function (e) {
                        const slug = e.target.value
                            .toLowerCase()
                            .replace(/[^a-z0-9]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                        slugInput.value = slug;
                    });
                }
            });
        </script>
    @endpush
@endsection