@extends('layouts.app')

@section('title', 'Login')

@section('content')
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <img src="{{ asset('/images/hero/hero.png') }}" alt="Login Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-leather-900/40 backdrop-blur-[2px]"></div>
        <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
            <h2 class="text-4xl font-serif font-bold mb-6">Welcome Back</h2>
            <p class="text-lg text-neutral-200 max-w-md">Sign in to access your account, track orders, and manage your wishlist.</p>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-white">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center lg:text-left">
                <h2 class="text-3xl font-serif font-bold text-leather-900">Sign in to your account</h2>
                <p class="mt-2 text-sm text-neutral-600">
                    Don't have an account? <a href="{{ route('register') }}" class="font-medium text-gold-600 hover:text-gold-500 transition-colors">Create a new account</a>
                </p>
            </div>

            <!-- Social Login Buttons -->
            <div class="grid grid-cols-3 gap-3 mt-8">
                <a href="#" class="flex items-center justify-center px-4 py-2 border border-neutral-300 rounded-lg shadow-sm bg-white text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition-colors">
                    <svg class="h-5 w-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                </a>
                <a href="#" class="flex items-center justify-center px-4 py-2 border border-neutral-300 rounded-lg shadow-sm bg-white text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition-colors">
                    <svg class="h-5 w-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="#" class="flex items-center justify-center px-4 py-2 border border-neutral-300 rounded-lg shadow-sm bg-white text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition-colors">
                    <svg class="h-5 w-5 text-[#E4405F]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-neutral-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-neutral-500">Or continue with email</span>
                </div>
            </div>

            <form x-data="loginForm()" @submit.prevent="submitLogin" class="space-y-6">
                @csrf
                
                <!-- Error Message -->
                <div x-show="errorMessage" x-transition class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <p x-text="errorMessage"></p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="email-address" class="block text-sm font-medium text-neutral-700 mb-1">Email address</label>
                        <input x-model="email" id="email-address" name="email" type="email" autocomplete="email" required 
                            class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm" 
                            placeholder="Enter your email">
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-neutral-700">Password</label>
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-gold-600 hover:text-gold-500 transition-colors">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <input x-model="password" :type="showPassword ? 'text' : 'password'" id="password" name="password" autocomplete="current-password" required 
                                class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm pr-10" 
                                placeholder="Enter your password">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-neutral-400 hover:text-neutral-600 focus:outline-none">
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-gold-600 focus:ring-gold-500 border-neutral-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-neutral-900">Remember me for 30 days</label>
                </div>

                <button type="submit" :disabled="loading" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Sign in</span>
                    <span x-show="loading">Signing in...</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function loginForm() {
        return {
            email: '',
            password: '',
            showPassword: false,
            loading: false,
            errorMessage: '',

            async submitLogin() {
                this.loading = true;
                this.errorMessage = '';
                
                try {
                    const response = await fetch('{{ route("login") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            email: this.email, 
                            password: this.password 
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        window.location.href = data.redirect;
                    } else {
                        this.errorMessage = data.message || (data.errors ? Object.values(data.errors).flat()[0] : 'Invalid credentials');
                    }
                } catch (error) {
                    this.errorMessage = 'Network error. Please try again.';
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endsection
