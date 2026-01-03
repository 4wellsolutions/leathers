@extends('layouts.admin')

@section('title', 'Edit Shipping Rule')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-leather-900">Edit Shipping Rule</h1>
            <p class="text-sm text-neutral-500">Update delivery charge rule</p>
        </div>

        <form action="{{ route('admin.shipping-rules.update', $shippingRule->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Rule Name *</label>
                    <input type="text" name="name" value="{{ old('name', $shippingRule->name) }}" required class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Min Amount (Rs.)</label>
                        <input type="number" name="min_amount" value="{{ old('min_amount', $shippingRule->min_amount) }}" step="0.01" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        @error('min_amount')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Max Amount (Rs.)</label>
                        <input type="number" name="max_amount" value="{{ old('max_amount', $shippingRule->max_amount) }}" step="0.01" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        @error('max_amount')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Delivery Cost (Rs.) *</label>
                    <input type="number" name="cost" value="{{ old('cost', $shippingRule->cost) }}" required step="0.01" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    @error('cost')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Priority *</label>
                    <input type="number" name="priority" value="{{ old('priority', $shippingRule->priority) }}" required class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    @error('priority')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_free" value="1" {{ old('is_free', $shippingRule->is_free) ? 'checked' : '' }} class="rounded border-neutral-300 text-gold-600 focus:ring-gold-500">
                        <span class="ml-2 text-sm text-neutral-700">Free Shipping</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $shippingRule->is_active) ? 'checked' : '' }} class="rounded border-neutral-300 text-gold-600 focus:ring-gold-500">
                        <span class="ml-2 text-sm text-neutral-700">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-between pt-6 border-t">
                    <a href="{{ route('admin.shipping-rules.index') }}" class="text-neutral-600 hover:text-neutral-900">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-leather-900 text-white rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-gold-500">
                        Update Rule
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
