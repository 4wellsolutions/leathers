@extends('layouts.admin')

@section('title', 'Inventory Report')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-white">Inventory Report</h1>
            <p class="mt-2 text-sm text-neutral-400">Generate detailed inventory reports with product stock information.</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-leather-800 rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.reports.inventory') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="category_id" class="block text-sm font-medium text-neutral-300 mb-2">
                        Filter by Category
                    </label>
                    <select name="category_id" id="category_id" 
                            class="w-full px-3 py-2 bg-leather-700 border border-leather-600 rounded-md text-white focus:ring-gold-500 focus:border-gold-500">
                        <option value="all" {{ (!request('category_id') || request('category_id') == 'all') ? 'selected' : '' }}>All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" 
                            class="px-4 py-2 bg-gold-500 text-white font-medium rounded-md hover:bg-gold-600 focus:outline-none focus:ring-2 focus:ring-gold-500">
                        Generate Report
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(isset($products))
        <!-- Report Results -->
        <div class="bg-leather-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-leather-700 sm:flex sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-medium text-white">
                        @if($selectedCategory)
                            {{ $selectedCategory->name }} - Inventory Report
                        @else
                            All Products - Inventory Report
                        @endif
                    </h2>
                    <p class="mt-1 text-sm text-neutral-400">Total Products: {{ $products->count() }}</p>
                </div>
                <div class="mt-3 sm:mt-0">
                    <a href="{{ route('admin.reports.inventory.pdf', ['category_id' => request('category_id')]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download PDF
                    </a>
                </div>
            </div>

            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-leather-700">
                        <thead class="bg-leather-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                                    Product Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                                    Colors
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                                    Sizes & Stock
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-leather-800 divide-y divide-leather-700">
                            @foreach($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ $product->image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-16 w-16 object-cover rounded-lg">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-white">{{ $product->name }}</div>
                                        <div class="text-sm text-neutral-400">SKU: {{ $product->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-leather-700 text-gold-400">
                                            {{ $product->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($product->colors->count() > 0)
                                            <div class="space-y-1">
                                                @foreach($product->colors as $color)
                                                    <div class="flex items-center">
                                                        <div class="w-4 h-4 rounded-full border border-neutral-600 mr-2" 
                                                             style="background-color: {{ $color->color_code }}"></div>
                                                        <span class="text-sm text-neutral-300">{{ $color->name }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-sm text-neutral-400">No colors</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($product->colors->count() > 0)
                                            <div class="space-y-2">
                                                @foreach($product->colors as $color)
                                                    @if($color->variants->count() > 0)
                                                        <div class="text-xs">
                                                            <span class="font-medium text-neutral-300">{{ $color->name }}:</span>
                                                            @foreach($color->variants as $variant)
                                                                <div class="ml-2 text-neutral-400">
                                                                    {{ $variant->size }} - <span class="font-semibold {{ $variant->stock > 0 ? 'text-green-400' : 'text-red-400' }}">{{ $variant->stock }} units</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-sm font-semibold {{ $product->stock > 0 ? 'text-green-400' : 'text-red-400' }}">
                                                {{ $product->stock }} units
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-neutral-300">No products found</h3>
                    <p class="mt-1 text-sm text-neutral-400">Try adjusting your filters.</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
