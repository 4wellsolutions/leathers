@extends('layouts.admin')

@section('title', 'Edit Coupon')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.coupons.index') }}" class="text-gray-500 hover:text-gray-700">
            &larr; Back to Coupons
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden max-w-2xl mx-auto">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Edit Coupon: {{ $coupon->code }}</h2>
        </div>

        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 uppercase"
                    placeholder="Ex. SUMMER2024">
                @error('code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                    <select name="type" id="type"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rs.)
                        </option>
                        <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>
                            Percentage (%)</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                    <input type="number" name="value" id="value" value="{{ old('value', $coupon->value) }}" required
                        step="0.01" min="0"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('value')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="min_order_amount" class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Amount
                    (Rs.)</label>
                <input type="number" name="min_order_amount" id="min_order_amount"
                    value="{{ old('min_order_amount', $coupon->min_order_amount) }}" step="0.01" min="0"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <p class="text-xs text-gray-500 mt-1">Leave blank for no minimum.</p>
                @error('min_order_amount')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                <input type="datetime-local" name="expires_at" id="expires_at"
                    value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <p class="text-xs text-gray-500 mt-1">Leave blank for no expiry.</p>
                @error('expires_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="inline-flex items-center">
                    <!-- Using hidden input for false value handling -->
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Update Coupon</button>
            </div>
        </form>
    </div>
@endsection