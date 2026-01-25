@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen flex">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/2 relative">
            <img src="{{ asset('/images/hero/hero.png') }}" alt="Login Background"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-leather-900/40 backdrop-blur-[2px]"></div>
            <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
                <h2 class="text-4xl font-serif font-bold mb-6">Welcome Back</h2>
                <p class="text-lg text-neutral-200 max-w-md">Sign in to access your account, track orders, and manage your
                    wishlist.</p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-white">
            <div class="max-w-md w-full space-y-8">
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-serif font-bold text-leather-900">Sign in to your account</h2>
                    <p class="mt-2 text-sm text-neutral-600">
                        Don't have an account? <a href="{{ route('register') }}"
                            class="font-medium text-gold-600 hover:text-gold-500 transition-colors">Create a new account</a>
                    </p>
                </div>

                <form x-data="loginForm()" @submit.prevent="submitLogin" class="space-y-6 mt-8">
                    @csrf

                    <!-- Error Message -->
                    <div x-show="errorMessage" x-transition
                        class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <p x-text="errorMessage"></p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-neutral-700 mb-1">Phone Number</label>
                            <input x-model="phone" id="phone" name="phone" type="tel" autocomplete="tel" required
                                class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm"
                                placeholder="+92 300 1234567">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-sm font-medium text-neutral-700">Password</label>
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-medium text-gold-600 hover:text-gold-500 transition-colors">Forgot
                                    password?</a>
                            </div>
                            <div class="relative">
                                <input x-model="password" :type="showPassword ? 'text' : 'password'" id="password"
                                    name="password" autocomplete="current-password" required
                                    class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm pr-10"
                                    placeholder="Enter your password">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-neutral-400 hover:text-neutral-600 focus:outline-none">
                                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox"
                            class="h-4 w-4 text-gold-600 focus:ring-gold-500 border-neutral-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-neutral-900">Remember me for 30 days</label>
                    </div>

                    <button type="submit" :disabled="loading"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
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
                phone: '',
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
                                phone: this.phone,
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