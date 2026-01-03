@extends('layouts.admin')

@section('title', 'Edit Deal: ' . $deal->name)

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('admin.deals.update', $deal->id) }}" method="POST" class="space-y-8 divide-y divide-neutral-200 p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-8 divide-y divide-neutral-200">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-leather-900">Deal Information</h3>
                    <p class="mt-1 text-sm text-neutral-500">Edit deal details.</p>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-leather-700">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name', $deal->name) }}" class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="discount_type" class="block text-sm font-medium text-leather-700">Discount Type</label>
                            <div class="mt-1">
                                <select id="discount_type" name="discount_type" class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                                    <option value="percentage" {{ old('discount_type', $deal->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="fixed" {{ old('discount_type', $deal->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rs.)</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="discount_value" class="block text-sm font-medium text-leather-700">Discount Value</label>
                            <div class="mt-1">
                                <input type="number" name="discount_value" id="discount_value" value="{{ old('discount_value', $deal->discount_value) }}" step="0.01" class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="start_date" class="block text-sm font-medium text-leather-700">Start Date</label>
                            <div class="mt-1">
                                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', $deal->start_date ? $deal->start_date->format('Y-m-d\TH:i') : '') }}" class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="end_date" class="block text-sm font-medium text-leather-700">End Date</label>
                            <div class="mt-1">
                                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', $deal->end_date ? $deal->end_date->format('Y-m-d\TH:i') : '') }}" class="shadow-sm focus:ring-gold-500 focus:border-gold-500 block w-full sm:text-sm border-neutral-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $deal->is_active) ? 'checked' : '' }} class="focus:ring-gold-500 h-4 w-4 text-gold-600 border-neutral-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_active" class="font-medium text-leather-700">Active</label>
                                    <p class="text-neutral-500">Enable or disable this deal.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <a href="{{ route('admin.deals.index') }}" class="bg-white py-2 px-4 border border-neutral-300 rounded-md shadow-sm text-sm font-medium text-leather-700 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">Cancel</a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">Update Deal</button>
                </div>
            </div>
        </form>
    </div>
@endsection
