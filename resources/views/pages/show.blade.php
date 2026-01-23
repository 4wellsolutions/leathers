@extends('layouts.app')

@section('meta_title', $meta_title)
@section('meta_description', $meta_description)

@section('content')
    <div class="bg-white py-12 sm:py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl font-serif">{{ $page->title }}</h1>
                <p class="mt-4 text-sm text-gray-500">Last updated: {{ $page->updated_at->format('F d, Y') }}</p>
            </div>

            <div class="mt-12 mx-auto max-w-4xl prose prose-lg prose-indigo text-gray-500">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection