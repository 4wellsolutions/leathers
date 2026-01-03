@extends('layouts.admin')

@section('title', 'Add Email Template')

@section('content')
    <form action="{{ route('admin.email-templates.store') }}" method="POST" class="pb-20">
        @csrf
        
        <!-- Sticky Header -->
        <div class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Add Email Template</h1>
                <p class="text-sm text-neutral-500">Create a new email template.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.email-templates.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all transform hover:-translate-y-0.5">
                    Create Template
                </button>
            </div>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="p-6 md:p-8 space-y-6">
                    <h2 class="text-lg font-semibold text-leather-900 border-b border-neutral-100 pb-4 mb-6">Template Details</h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Template Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4" placeholder="e.g. order_confirmation">
                            <p class="mt-1 text-xs text-neutral-500">Unique identifier for this template (use lowercase with underscores)</p>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-neutral-700 mb-2">Email Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4" placeholder="e.g. Order Confirmation - @{{order_number}}">
                        </div>

                        <div>
                            <label for="body" class="block text-sm font-medium text-neutral-700 mb-2">Email Body</label>
                            <textarea id="body" name="body" rows="12" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4 font-mono text-sm" placeholder="Enter email template HTML...">{{ old('body') }}</textarea>
                            <p class="mt-1 text-xs text-neutral-500">Use double curly braces for variables: {{variable_name}}</p>
                        </div>

                        <div>
                            <label for="variables" class="block text-sm font-medium text-neutral-700 mb-2">Available Variables <span class="text-neutral-400 font-normal">(Optional)</span></label>
                            <textarea id="variables" name="variables" rows="3" class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4" placeholder='e.g. {"customer_name", "order_number", "order_total"}'>{{ old('variables') }}</textarea>
                            <p class="mt-1 text-xs text-neutral-500">List available variables for reference (comma-separated or JSON array)</p>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900">Active Status</span>
                                <span class="text-xs text-neutral-500">Enable this template</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
