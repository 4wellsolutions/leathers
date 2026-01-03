@extends('layouts.admin')

@section('title', 'Cache Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-leather-900">Cache Management</h2>
                <p class="text-neutral-600 mt-1">Clear and rebuild application caches for optimal performance</p>
            </div>
            <div class="flex space-x-3">
                <form action="{{ route('admin.cache.rebuild') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Rebuild Cache
                    </button>
                </form>
                <form action="{{ route('admin.cache.clear-all') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to clear all caches?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Clear All Cache
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Cache Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Config Cache -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-leather-900">Config Cache</h3>
                @if($cacheInfo['config']['exists'])
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">Cached</span>
                @else
                    <span class="px-2 py-1 bg-neutral-100 text-neutral-800 text-xs font-semibold rounded">Not Cached</span>
                @endif
            </div>
            <p class="text-sm text-neutral-600 mb-4">
                Size: {{ $cacheInfo['config']['exists'] ? number_format($cacheInfo['config']['size'] / 1024, 2) . ' KB' : 'N/A' }}
            </p>
            <form action="{{ route('admin.cache.clear', 'config') }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-neutral-100 text-neutral-700 rounded-lg hover:bg-neutral-200 transition-colors text-sm font-medium">
                    Clear Config Cache
                </button>
            </form>
        </div>

        <!-- Route Cache -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-leather-900">Route Cache</h3>
                @if($cacheInfo['routes']['exists'])
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">Cached</span>
                @else
                    <span class="px-2 py-1 bg-neutral-100 text-neutral-800 text-xs font-semibold rounded">Not Cached</span>
                @endif
            </div>
            <p class="text-sm text-neutral-600 mb-4">
                Size: {{ $cacheInfo['routes']['exists'] ? number_format($cacheInfo['routes']['size'] / 1024, 2) . ' KB' : 'N/A' }}
            </p>
            <form action="{{ route('admin.cache.clear', 'route') }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-neutral-100 text-neutral-700 rounded-lg hover:bg-neutral-200 transition-colors text-sm font-medium">
                    Clear Route Cache
                </button>
            </form>
        </div>

        <!-- View Cache -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-leather-900">View Cache</h3>
                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">{{ $cacheInfo['views']['count'] }} files</span>
            </div>
            <p class="text-sm text-neutral-600 mb-4">
                Size: {{ number_format($cacheInfo['views']['size'] / 1024, 2) }} KB
            </p>
            <form action="{{ route('admin.cache.clear', 'view') }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-neutral-100 text-neutral-700 rounded-lg hover:bg-neutral-200 transition-colors text-sm font-medium">
                    Clear View Cache
                </button>
            </form>
        </div>

        <!-- Application Cache -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-leather-900">App Cache</h3>
                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">{{ $cacheInfo['cache']['count'] }} files</span>
            </div>
            <p class="text-sm text-neutral-600 mb-4">
                Size: {{ number_format($cacheInfo['cache']['size'] / 1024, 2) }} KB
            </p>
            <form action="{{ route('admin.cache.clear', 'cache') }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-neutral-100 text-neutral-700 rounded-lg hover:bg-neutral-200 transition-colors text-sm font-medium">
                    Clear App Cache
                </button>
            </form>
        </div>
    </div>

    <!-- Build Assets Info -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-leather-900 mb-4">Build Assets Status</h3>
        
        @if($cacheInfo['build']['exists'])
            <div class="flex items-center space-x-2 mb-4">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-green-600 font-medium">Build manifest found</span>
            </div>
            
            @if($cacheInfo['build']['manifest'])
                <div class="bg-neutral-50 rounded-lg p-4">
                    <h4 class="font-medium text-neutral-900 mb-3">Compiled Assets:</h4>
                    <div class="space-y-2">
                        @foreach($cacheInfo['build']['manifest'] as $key => $asset)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-neutral-600">{{ $key }}</span>
                                <span class="text-neutral-900 font-mono">{{ $asset['file'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="flex items-center space-x-2 text-amber-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="font-medium">Build manifest not found!</span>
            </div>
            <p class="text-sm text-neutral-600 mt-2">
                Run <code class="bg-neutral-100 px-2 py-1 rounded">npm run build</code> locally and upload the <code class="bg-neutral-100 px-2 py-1 rounded">public/build/</code> folder.
            </p>
        @endif
    </div>

    <!-- Environment Info -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-leather-900 mb-4">Environment Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <span class="text-sm text-neutral-600">Environment:</span>
                <span class="ml-2 px-2 py-1 bg-{{ config('app.env') === 'production' ? 'green' : 'amber' }}-100 text-{{ config('app.env') === 'production' ? 'green' : 'amber' }}-800 text-xs font-semibold rounded">
                    {{ strtoupper(config('app.env')) }}
                </span>
            </div>
            <div>
                <span class="text-sm text-neutral-600">Debug Mode:</span>
                <span class="ml-2 px-2 py-1 bg-{{ config('app.debug') ? 'red' : 'green' }}-100 text-{{ config('app.debug') ? 'red' : 'green' }}-800 text-xs font-semibold rounded">
                    {{ config('app.debug') ? 'ENABLED' : 'DISABLED' }}
                </span>
            </div>
            <div>
                <span class="text-sm text-neutral-600">URL:</span>
                <span class="ml-2 text-sm font-mono text-neutral-900">{{ config('app.url') }}</span>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">💡 When to Clear Cache</h3>
        <ul class="space-y-2 text-sm text-blue-800">
            <li class="flex items-start">
                <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span><strong>After deployment:</strong> Clear all caches and rebuild for production</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span><strong>Config changes:</strong> Clear config cache after modifying .env or config files</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span><strong>View updates:</strong> Clear view cache if Blade templates don't update</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span><strong>Route changes:</strong> Clear route cache after adding/modifying routes</span>
            </li>
        </ul>
    </div>
</div>
@endsection
