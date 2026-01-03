@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <img src="{{ asset('/images/hero/hero.png') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-leather-900/40 backdrop-blur-[2px]"></div>
        <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
            <h2 class="text-4xl font-serif font-bold mb-6">Verify OTP</h2>
            <p class="text-lg text-neutral-200 max-w-md">Please enter the 6-digit code sent to your email address.</p>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-white">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center lg:text-left">
                <h2 class="text-3xl font-serif font-bold text-leather-900">Enter OTP</h2>
                <p class="mt-2 text-sm text-neutral-600">
                    Code sent to <span class="font-semibold">{{ $email }}</span>
                </p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form class="space-y-6" action="{{ route('password.verify.post') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div>
                    <label for="otp" class="block text-sm font-medium text-neutral-700 mb-1">One-Time Password</label>
                    <input id="otp" name="otp" type="text" required 
                        class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm tracking-widest text-center text-2xl" 
                        placeholder="123456" maxlength="6">
                    @error('otp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all transform hover:-translate-y-0.5">
                    Verify & Proceed
                </button>
                
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-gold-600 hover:text-gold-500">Resend Code</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
