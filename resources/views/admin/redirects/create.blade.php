@extends('layouts.admin')

@section('title', 'Create Redirect')

@section('content')
<form action="{{ route('admin.redirects.store') }}" method="POST" class="max-w-2xl mx-auto pb-20">
    @csrf
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-leather-900">Create Redirect</h1>
            <p class="text-sm text-neutral-500">Add a new URL redirection rule.</p>
        </div>
        <a href="{{ route('admin.redirects.index') }}" class="text-sm font-medium text-neutral-600 hover:text-neutral-900">Cancel</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden p-6 space-y-6">
        <div>
            <label for="old_url" class="block text-sm font-medium text-neutral-700 mb-2">Old URL (Relative)</label>
            <div class="flex rounded-lg shadow-sm">
                 <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
                    {{ config('app.url') }}/
                </span>
                <input type="text" name="old_url" id="old_url" value="{{ old('old_url') }}" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-lg focus:ring-gold-500 focus:border-gold-500 sm:text-sm border-neutral-300" placeholder="products/old-product">
            </div>
             <p class="mt-1 text-xs text-neutral-500">Do not include the domain name.</p>
        </div>

        <div>
            <label for="new_url" class="block text-sm font-medium text-neutral-700 mb-2">New URL (Relative or Absolute)</label>
            <input type="text" name="new_url" id="new_url" value="{{ old('new_url') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4" placeholder="/products/new-product">
        </div>

        <div>
            <label for="status_code" class="block text-sm font-medium text-neutral-700 mb-2">HTTP Status Code</label>
            <select name="status_code" id="status_code" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                <option value="301" {{ old('status_code') == '301' ? 'selected' : '' }}>301 - Permanent Redirect</option>
                <option value="302" {{ old('status_code') == '302' ? 'selected' : '' }}>302 - Temporary Redirect</option>
            </select>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
            <div class="flex flex-col">
                <span class="text-sm font-medium text-neutral-900">Active Status</span>
                <span class="text-xs text-neutral-500">Enable or disable this redirect</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
            </label>
        </div>
    </div>

    <div class="mt-8 flex items-center justify-end">
        <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 shadow-sm">
            Create Redirect
        </button>
    </div>
</form>
@endsection
