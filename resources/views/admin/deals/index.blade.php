@extends('layouts.admin')

@section('title', 'Deals')

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Deals</h1>
                <p class="text-sm text-neutral-500 mt-1">Manage bundle deals and promotions</p>
            </div>
            <a href="{{ route('admin.deals.create') }}"
                class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-semibold rounded-xl shadow-sm text-white bg-gold-600 hover:bg-gold-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Deal
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-neutral-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-gold-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-leather-900">{{ $deals->total() }}</p>
                <p class="text-xs text-neutral-500">Total Deals</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-neutral-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-green-600">{{ $deals->getCollection()->filter(fn($d) => $d->is_active && $d->isValid())->count() }}</p>
                <p class="text-xs text-neutral-500">Active Deals</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-neutral-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-red-500">{{ $deals->getCollection()->filter(fn($d) => !$d->is_active || !$d->isValid())->count() }}</p>
                <p class="text-xs text-neutral-500">Inactive Deals</p>
            </div>
        </div>
    </div>

    {{-- Deals Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead>
                    <tr class="bg-neutral-50">
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Deal</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Products</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Duration</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($deals as $deal)
                        @php
                            $isActive = $deal->is_active && $deal->isValid();
                        @endphp
                        <tr class="hover:bg-neutral-50 transition-colors">
                            {{-- Deal Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden border border-neutral-200 flex-shrink-0 bg-neutral-100">
                                        @if($deal->image)
                                            <img src="{{ asset($deal->image) }}" alt="{{ $deal->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-neutral-400">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-leather-900 truncate max-w-xs">{{ $deal->name }}</p>
                                        <p class="text-xs text-neutral-400 truncate max-w-xs">{{ $deal->slug }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Price --}}
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-leather-900">Rs. {{ number_format($deal->price) }}</span>
                            </td>

                            {{-- Products --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <div class="flex -space-x-2">
                                        @foreach($deal->products->take(3) as $product)
                                            <div class="w-7 h-7 rounded-full border-2 border-white overflow-hidden bg-neutral-100" title="{{ $product->name }}">
                                                <img src="{{ $product->image_url }}" alt="" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                    </div>
                                    <span class="text-xs font-medium text-neutral-500 ml-1">{{ $deal->products->count() }} item{{ $deal->products->count() !== 1 ? 's' : '' }}</span>
                                </div>
                            </td>

                            {{-- Duration --}}
                            <td class="px-6 py-4">
                                @if($deal->start_date && $deal->end_date)
                                    <div class="text-xs text-neutral-600">
                                        <div>{{ $deal->start_date->format('M d, Y') }}</div>
                                        <div class="text-neutral-400">to {{ $deal->end_date->format('M d, Y') }}</div>
                                    </div>
                                @else
                                    <span class="text-xs text-neutral-400 italic">No dates set</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($isActive)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('deals.show', $deal->slug) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-blue-600 hover:bg-blue-50 transition" title="View on site">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.deals.edit', $deal->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-gold-600 hover:bg-gold-50 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.deals.destroy', $deal->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this deal?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-red-600 hover:bg-red-50 transition" title="Delete">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-600 mb-1">No deals yet</p>
                                    <p class="text-xs text-neutral-400 mb-4">Create your first bundle deal to get started</p>
                                    <a href="{{ route('admin.deals.create') }}" class="text-sm font-medium text-gold-600 hover:text-gold-700">
                                        + Create Deal
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($deals->hasPages())
            <div class="px-6 py-4 border-t border-neutral-200 bg-neutral-50">
                {{ $deals->links() }}
            </div>
        @endif
    </div>
@endsection