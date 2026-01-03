@extends('layouts.admin')

@section('title', 'Sitemap Generator')

@section('content')
    <!-- Sticky Header -->
    <div class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Sitemap Generator</h1>
                <p class="text-sm text-neutral-500">Generate XML sitemap for search engines</p>
            </div>
            <div class="flex items-center space-x-3">
                @if(file_exists(public_path('sitemap.xml')))
                    <a href="{{ route('admin.sitemap.download') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download
                    </a>
                @endif
                <form action="{{ route('admin.sitemap.generate') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Generate Sitemap
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-leather-100 text-leather-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Products</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-leather-900">{{ $stats['products'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-blue-100 text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Categories</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-blue-600">{{ $stats['categories'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-purple-100 text-purple-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Pages</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-purple-600">{{ $stats['pages'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-gold-100 text-gold-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 truncate">Total URLs</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gold-600">{{ $stats['total_urls'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sitemap Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
        <div class="p-6 md:p-8">
            <h2 class="text-lg font-semibold text-leather-900 mb-4">Sitemap Structure</h2>
            <div class="prose max-w-none">
                <p class="text-neutral-600">Your site uses a segmented sitemap structure for better SEO. Each content type has its own sitemap, all referenced in the main sitemap index.</p>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-base font-semibold text-leather-900 mb-2">Generated Sitemaps</h3>
                        <ul class="list-disc list-inside text-neutral-600 space-y-1 font-mono text-sm">
                            <li>sitemap.xml (Index)</li>
                            <li>sitemap-pages.xml</li>
                            <li>sitemap-categories.xml</li>
                            <li>sitemap-products.xml</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-leather-900 mb-2">Best Practices</h3>
                        <ul class="list-disc list-inside text-neutral-600 space-y-1">
                            <li>Regenerate after content updates</li>
                            <li>Submit to Google Search Console</li>
                            <li>Submit to Bing Webmaster Tools</li>
                            <li>Add to robots.txt file</li>
                        </ul>
                    </div>
                </div>

                @if(file_exists(public_path('sitemap.xml')))
                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-green-600 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-green-800">Sitemaps Generated ({{ $stats['sitemaps_generated'] }} files)</p>
                                <p class="mt-1 text-sm text-green-700">Main sitemap index: <code class="px-2 py-0.5 bg-green-100 rounded">{{ config('app.url') }}/sitemap.xml</code></p>
                                <p class="mt-1 text-xs text-green-600">Last modified: {{ date('M d, Y H:i', filemtime(public_path('sitemap.xml'))) }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-yellow-600 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-800">No Sitemaps Found</p>
                                <p class="mt-1 text-sm text-yellow-700">Click "Generate Sitemap" above to create all sitemap files.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
