@extends('layouts.admin')

@section('title', 'Shipping Rules')

@section('content')
    <div class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Shipping Rules</h1>
                <p class="text-sm text-neutral-500">Manage delivery charges and free shipping thresholds</p>
            </div>
            <a href="{{ route('admin.shipping-rules.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Rule
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-neutral-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Min Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Max Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Cost</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-neutral-200">
                @forelse($shippingRules as $rule)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-6 py-4 text-sm font-medium text-leather-900">{{ $rule->name }}</td>
                        <td class="px-6 py-4 text-sm text-neutral-600">
                            {{ $rule->min_amount ? 'Rs. ' . number_format($rule->min_amount) : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-600">
                            {{ $rule->max_amount ? 'Rs. ' . number_format($rule->max_amount) : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold {{ $rule->is_free ? 'text-green-600' : 'text-leather-900' }}">
                            {{ $rule->is_free ? 'FREE' : 'Rs. ' . number_format($rule->cost) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rule->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $rule->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('admin.shipping-rules.edit', $rule->id) }}" class="text-gold-600 hover:text-gold-900 mr-3">Edit</a>
                            <form action="{{ route('admin.shipping-rules.destroy', $rule->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-neutral-500">
                            No shipping rules found. Create one to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
