@extends('layouts.admin')

@section('title', 'Edit Sale: ' . $sale->name)

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('admin.sales.update', $sale->id) }}" method="POST"
            class="space-y-8 divide-y divide-neutral-200 p-6">
            @csrf
            @method('PUT')

            <div class="space-y-8 divide-y divide-neutral-200">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-leather-900">Sale Information</h3>
                    <p class="mt-1 text-sm text-neutral-500">Edit sale details.</p>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-leather-700">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name', $sale->name) }}"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md"
                                    required>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="slug" class="block text-sm font-medium text-leather-700">Slug</label>
                            <div class="mt-1">
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $sale->slug) }}"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md bg-neutral-50"
                                    readonly>
                                <p class="mt-1 text-xs text-neutral-500">Auto-generated from name. Change name to update
                                    slug.</p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="discount_type" class="block text-sm font-medium text-leather-700">Discount
                                Type</label>
                            <div class="mt-1">
                                <select id="discount_type" name="discount_type"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                                    <option value="percentage" {{ old('discount_type', $sale->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="fixed" {{ old('discount_type', $sale->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rs.)</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="discount_value" class="block text-sm font-medium text-leather-700">Discount
                                Value</label>
                            <div class="mt-1">
                                <input type="number" name="discount_value" id="discount_value"
                                    value="{{ old('discount_value', $sale->discount_value) }}" step="0.01"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md"
                                    required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="start_date" class="block text-sm font-medium text-leather-700">Start Date</label>
                            <div class="mt-1">
                                <input type="datetime-local" name="start_date" id="start_date"
                                    value="{{ old('start_date', $sale->start_date ? $sale->start_date->format('Y-m-d\TH:i') : '') }}"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="end_date" class="block text-sm font-medium text-leather-700">End Date</label>
                            <div class="mt-1">
                                <input type="datetime-local" name="end_date" id="end_date"
                                    value="{{ old('end_date', $sale->end_date ? $sale->end_date->format('Y-m-d\TH:i') : '') }}"
                                    class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $sale->is_active) ? 'checked' : '' }}
                                        class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-neutral-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_active" class="font-medium text-leather-700">Active</label>
                                    <p class="text-neutral-500">Enable or disable this sale.</p>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-6 border-t border-neutral-200 pt-6">
                            <label class="block text-sm font-medium text-leather-700 mb-4">Select Products for this Sale</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto p-4 border border-neutral-200 rounded-md bg-neutral-50">
                                @foreach($products as $product)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="product_{{ $product->id }}" name="products[]" type="checkbox" value="{{ $product->id }}" 
                                                class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-neutral-300 rounded"
                                                {{ (is_array(old('products')) && in_array($product->id, old('products'))) || ($product->sale_id == $sale->id) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="product_{{ $product->id }}" class="font-medium text-leather-700">{{ $product->name }}</label>
                                            <p class="text-neutral-500">Price: Rs. {{ number_format($product->price) }}</p>
                                            @if($product->sale_id && $product->sale_id != $sale->id)
                                                <p class="text-xs text-red-500">Currently in another sale</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="mt-2 text-sm text-neutral-500">Select the products that will be part of this sale. Any previously assigned sale will be overwritten.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <a href="{{ route('admin.sales.index') }}"
                        class="bg-white py-2 px-4 border border-neutral-300 rounded-md shadow-sm text-sm font-medium text-leather-700 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">Cancel</a>
                    <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">Update
                        Sale</button>
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