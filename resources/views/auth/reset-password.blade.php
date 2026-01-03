@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <img src="{{ asset('/images/hero/hero.png') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-leather-900/40 backdrop-blur-[2px]"></div>
        <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
            <h2 class="text-4xl font-serif font-bold mb-6">Reset Password</h2>
            <p class="text-lg text-neutral-200 max-w-md">Create a new strong password for your account.</p>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-white">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center lg:text-left">
                <h2 class="text-3xl font-serif font-bold text-leather-900">New Password</h2>
            </div>

            <form class="space-y-6" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="space-y-5">
                    <div>
                        <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">New Password</label>
                        <input id="password" name="password" type="password" required 
                            class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm" 
                            placeholder="Enter new password">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                            class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm" 
                            placeholder="Confirm new password">
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all transform hover:-translate-y-0.5">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
