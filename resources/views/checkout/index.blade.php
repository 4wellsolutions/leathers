@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Stepper -->
        <div class="mb-12">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 rounded-full bg-gold-600 text-white flex items-center justify-center font-bold text-sm">
                        1</div>
                    <span class="ml-2 text-sm font-medium text-leather-900">Cart</span>
                </div>
                <div class="w-16 h-px bg-gold-200"></div>
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 rounded-full bg-gold-600 text-white flex items-center justify-center font-bold text-sm">
                        2</div>
                    <span class="ml-2 text-sm font-bold text-leather-900">Checkout</span>
                </div>
                <div class="w-16 h-px bg-neutral-200"></div>
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 rounded-full bg-neutral-200 text-neutral-500 flex items-center justify-center font-bold text-sm">
                        3</div>
                    <span class="ml-2 text-sm font-medium text-neutral-400">Payment</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Main Content -->
            <div class="flex-grow">
                @guest
                    <!-- Authentication Options for Guest Users -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-100 p-8 mb-8"
                        x-data="{ selected: 'guest' }">
                        <h2 class="text-xl font-serif font-bold text-leather-900 mb-6">
                            Choose Checkout Method
                        </h2>

                        <div class="grid grid-cols-3 gap-2 mb-6">
                            <!-- Guest Checkout -->
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="checkout_method" value="guest" x-model="selected"
                                    @change="scrollToForm('guest-info')" class="peer sr-only">
                                <div
                                    class="h-full border border-neutral-200 rounded-lg p-3 peer-checked:border-gold-500 peer-checked:bg-gold-50/50 transition-all duration-300 hover:shadow-md relative overflow-hidden text-center flex flex-col items-center justify-center">
                                    <div class="mb-1 text-neutral-400 peer-checked:text-gold-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                    </div>
                                    <h3 class="font-bold text-leather-900 text-xs sm:text-sm leading-tight">Guest</h3>
                                    <p class="hidden sm:block text-[10px] text-neutral-500 mt-1">Quick checkout</p>
                                </div>
                            </label>

                            <!-- Login -->
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="checkout_method" value="login" x-model="selected"
                                    @change="scrollToForm('login-form')" class="peer sr-only">
                                <div
                                    class="h-full border border-neutral-200 rounded-lg p-3 peer-checked:border-gold-500 peer-checked:bg-gold-50/50 transition-all duration-300 hover:shadow-md relative overflow-hidden text-center flex flex-col items-center justify-center">
                                    <div class="mb-1 text-neutral-400 peer-checked:text-gold-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                                    </div>
                                    <h3 class="font-bold text-leather-900 text-xs sm:text-sm leading-tight">Login</h3>
                                    <p class="hidden sm:block text-[10px] text-neutral-500 mt-1">Existing User</p>
                                </div>
                            </label>

                            <!-- Register -->
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="checkout_method" value="register" x-model="selected"
                                    @change="scrollToForm('register-form')" class="peer sr-only">
                                <div
                                    class="h-full border border-neutral-200 rounded-lg p-3 peer-checked:border-gold-500 peer-checked:bg-gold-50/50 transition-all duration-300 hover:shadow-md relative overflow-hidden text-center flex flex-col items-center justify-center">
                                    <div class="mb-1 text-neutral-400 peer-checked:text-gold-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                    </div>
                                    <h3 class="font-bold text-leather-900 text-xs sm:text-sm leading-tight">Register</h3>
                                    <p class="hidden sm:block text-[10px] text-neutral-500 mt-1">New User</p>
                                </div>
                            </label>
                        </div>

                        <!-- Login Form -->
                        <div id="login-form" x-show="selected === 'login'" x-transition class="bg-neutral-50 rounded-lg p-6"
                            x-data="{ showPassword: false, loginError: '' }">
                            <h3 class="font-bold text-leather-900 mb-4">Sign in to continue</h3>
                            <form action="{{ route('login') }}" method="POST" @submit.prevent="handleLogin" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="login_email"
                                        class="block text-sm font-semibold text-neutral-700 mb-2">Email</label>
                                    <input type="email" id="login_email" name="email" required
                                        class="w-full px-4 py-3 rounded-lg border-2 border-neutral-200 focus:border-gold-500 focus:ring-2 focus:ring-gold-200 transition-colors"
                                        placeholder="your@email.com">
                                </div>
                                <div>
                                    <label for="login_password"
                                        class="block text-sm font-semibold text-neutral-700 mb-2">Password</label>
                                    <div class="relative">
                                        <input :type="showPassword ? 'text' : 'password'" id="login_password" name="password"
                                            required
                                            class="w-full px-4 py-3 rounded-lg border-2 border-neutral-200 focus:border-gold-500 focus:ring-2 focus:ring-gold-200 transition-colors pr-10"
                                            placeholder="Enter your password">
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600">
                                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" style="display: none;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div x-show="loginError" x-text="loginError"
                                    class="text-red-600 text-sm bg-red-50 p-3 rounded-lg"></div>
                                <button type="submit" class="w-full btn-primary">Sign In & Continue</button>
                                <p class="text-sm text-center text-neutral-600">
                                    <a href="{{ route('password.request') }}"
                                        class="text-gold-600 hover:text-gold-700 font-medium">Forgot password?</a>
                                </p>
                            </form>
                        </div>

                        <!-- Register Form -->
                        <div id="register-form" x-show="selected === 'register'" x-transition
                            class="bg-neutral-50 rounded-lg p-6" x-data="{ showPassword: false, registerError: '' }">
                            <h3 class="font-bold text-leather-900 mb-4">Create an account</h3>
                            <form action="{{ route('register') }}" method="POST" @submit.prevent="handleRegister"
                                class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="reg_first_name"
                                            class="block text-sm font-semibold text-neutral-700 mb-2">First Name</label>
                                        <input type="text" id="reg_first_name" name="first_name" required
                                            class="w-full px-4 py-3 rounded-lg border-2 border-neutral-200 focus:border-gold-500 focus:ring-2 focus:ring-gold-200 transition-colors"
                                            placeholder="John">
                                    </div>
                                    <div>
                                        <label for="reg_last_name"
                                            class="block text-sm font-semibold text-neutral-700 mb-2">Last Name</label>
                                        <input type="text" id="reg_last_name" name="last_name" required
                                            class="w-full px-4 py-3 rounded-lg border-2 border-neutral-200 focus:border-gold-500 focus:ring-2 focus:ring-gold-200 transition-colors"
                                            placeholder="Doe">
                                    </div>
                                </div>
                                <div>
                                    <label for="reg_email"
                                        class="block text-sm font-semibold text-neutral-700 mb-2">Email</label>
                                    <input type="email" id="reg_email" name="email" required
                                        class="w-full px-4 py-3 rounded-lg border-2 border-neutral-200 focus:border-gold-500 focus:ring-2 focus:ring-gold-200 transition-colors"
                                        placeholder="your@email.com">
                                </div>
                                <div>
                                    <label for="reg_password"
                                        class="block text-sm font-semibold text-neutral-700 mb-2">Password</label>
                                    <div class="relative">
                                        <input :type="showPassword ? 'text' : 'password'" id="reg_password" name="password"
                                            required
                                            class="w-full px-4 py-3 rounded-lg border-2 border-neutral-200 focus:border-gold-500 focus:ring-2 focus:ring-gold-200 transition-colors pr-10"
                                            placeholder="Min. 8 characters">
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600">
                                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" style="display: none;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div x-show="registerError" x-text="registerError"
                                    class="text-red-600 text-sm bg-red-50 p-3 rounded-lg"></div>
                                <button type="submit" class="w-full btn-primary">Create Account & Continue</button>
                            </form>
                        </div>

                        <!-- Guest Checkout Info -->
                        <div id="guest-info" x-show="selected === 'guest'" x-transition
                            class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-blue-900 mb-1">Checkout as Guest</h4>
                                    <p class="text-sm text-blue-700">Continue without creating an account. You can still track
                                        your order via email.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest

                @auth
                    <!-- Logged In User Info -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-900">Signed in as {{ Auth::user()->name }}</p>
                                    <p class="text-sm text-green-700">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-green-700 hover:text-green-900 font-medium">Sign
                                    Out</button>
                            </form>
                        </div>
                    </div>
                @endauth

                <!-- Shipping Information Form -->
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-100 p-8 mb-8">
                        <h2 class="text-xl font-serif font-bold text-leather-900 mb-6 border-b border-neutral-100 pb-4">
                            Shipping Information</h2>

                        @if($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                                <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
                                <ul class="list-disc list-inside text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="first_name" class="block text-sm font-semibold text-neutral-700 mb-2">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" id="first_name"
                                    value="{{ old('first_name', Auth::user()->first_name ?? '') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 bg-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all shadow-sm @error('first_name') border-red-500 @enderror"
                                    placeholder="Enter your first name">
                                @error('first_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-semibold text-neutral-700 mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" id="last_name"
                                    value="{{ old('last_name', Auth::user()->last_name ?? '') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 bg-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all shadow-sm @error('last_name') border-red-500 @enderror"
                                    placeholder="Enter your last name">
                                @error('last_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-neutral-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', Auth::user()->email ?? '') }}" required
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                class="w-full px-4 py-3 rounded-xl border border-neutral-300 bg-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all shadow-sm @error('email') border-red-500 @enderror"
                                placeholder="example@email.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-neutral-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                required pattern="[0-9+\-\s()]{10,15}"
                                class="w-full px-4 py-3 rounded-xl border border-neutral-300 bg-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all shadow-sm @error('phone') border-red-500 @enderror"
                                placeholder="+92 300 1234567">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-neutral-500 mt-1">Format: +92 300 1234567 or 03001234567</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="address" class="block text-sm font-semibold text-neutral-700 mb-2">
                            Street Address <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-neutral-300 bg-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all shadow-sm @error('address') border-red-500 @enderror"
                            placeholder="House number, street name, area">
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="city" class="block text-sm font-semibold text-neutral-700 mb-2">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-neutral-300 bg-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all shadow-sm @error('city') border-red-500 @enderror"
                            placeholder="Enter your city">
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-semibold text-neutral-700 mb-2">
                            Order Notes <span class="text-neutral-400 text-xs font-normal">(Optional)</span>
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-neutral-300 bg-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all shadow-sm"
                            placeholder="Any special instructions for your order?">{{ old('notes') }}</textarea>
                    </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-neutral-100 p-8">
                <h2 class="text-xl font-serif font-bold text-leather-900 mb-6 border-b border-neutral-100 pb-4">
                    Payment Method</h2>
                <div class="space-y-4">
                    <label
                        class="flex items-center space-x-4 cursor-pointer p-5 border-2 border-gold-500 bg-gold-50/30 rounded-xl hover:bg-gold-50 transition-all shadow-sm">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 rounded-full border-2 border-gold-600 flex items-center justify-center">
                                <div class="w-3 h-3 rounded-full bg-gold-600"></div>
                            </div>
                        </div>
                        <div>
                            <span class="font-bold text-leather-900 block text-lg">Cash on Delivery</span>
                            <span class="text-sm text-neutral-600">Pay securely with cash when you receive your order</span>
                        </div>
                    </label>
                    <label
                        class="flex items-center space-x-4 cursor-not-allowed p-5 border border-neutral-200 rounded-xl bg-neutral-50 opacity-60">
                        <input type="radio" name="payment_method" value="card" disabled
                            class="w-5 h-5 text-neutral-400 border-neutral-300">
                        <div>
                            <span class="font-semibold text-neutral-500 block">Credit/Debit Card</span>
                            <span class="text-xs text-neutral-400">Online payment unavailable temporarily</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Hidden submit button for programmatic submission -->
            <button type="submit" id="hidden-submit" class="hidden">Submit</button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="w-full lg:w-96 flex-shrink-0">
            <div class="bg-neutral-50 rounded-xl shadow-sm border border-neutral-200 p-6 lg:sticky lg:top-24">
                <h2
                    class="text-lg font-serif font-bold text-leather-900 mb-6 border-b border-neutral-200 pb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gold-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Your Order
                </h2>

                <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($cart as $details)
                        <div class="flex items-center space-x-4 p-3 bg-white rounded-lg border border-neutral-200 shadow-sm">
                            <div
                                class="w-16 h-16 flex-shrink-0 bg-neutral-100 rounded-md overflow-hidden border border-neutral-200">
                                <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}"
                                    class="w-full h-full object-contain p-1">
                            </div>
                            <div class="flex-grow min-w-0">
                                <h4 class="text-sm font-bold text-leather-900 truncate">{{ $details['name'] }}</h4>
                                <p class="text-xs text-neutral-500">Qty: {{ $details['quantity'] }}</p>
                                <p class="text-sm font-semibold text-gold-600">Rs.
                                    {{ number_format($details['price'] * $details['quantity']) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-3 pt-4 border-t border-neutral-200">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-neutral-600 font-medium">Subtotal</span>
                        <span class="text-leather-900 font-bold">Rs. {{ number_format($subtotal) }}</span>
                    </div>

                    <div class="flex justify-between items-center text-sm pb-3 border-b border-neutral-200">
                        <span class="text-neutral-600 font-medium">Shipping</span>
                        @if($shippingCost == 0)
                            <span
                                class="text-green-600 font-bold bg-green-100 px-2.5 py-1 rounded-full text-[10px] uppercase tracking-wider">FREE
                                DELIVERY</span>
                        @else
                            <span class="text-leather-900 font-bold">Rs. {{ number_format($shippingCost) }}</span>
                        @endif
                    </div>

                    <div class="flex justify-between items-end pt-1">
                        <span class="text-base font-bold text-leather-900">Total</span>
                        <div class="text-right">
                            <span class="text-3xl font-serif font-bold text-gold-600 leading-none">Rs.
                                {{ number_format($total) }}</span>
                            <p class="text-[10px] text-neutral-400 mt-1 uppercase tracking-tighter">VAT & Taxes Included
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Desktop Submit Button -->
                <button type="button" onclick="submitCheckout()"
                    class="hidden lg:flex mt-6 w-full btn-primary py-4 text-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all justify-center items-center group bg-gradient-to-r from-leather-900 to-leather-800 border-none">
                    <span>Place Order</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>

                <!-- Mobile Static Submit Button -->
                <button type="button" onclick="submitCheckout()"
                    class="lg:hidden w-full mt-6 btn-primary py-4 text-base font-bold shadow-lg bg-gold-500 text-leather-900 hover:bg-gold-600 border-none transition-all flex justify-center items-center rounded-xl">
                    <span>Place My Order</span>
                    <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <script>
        function handleLogin(event) {
            const form = event.target;
            const formData = new FormData(form);

            fetch('{{ route('login') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        Alpine.store('loginError', data.message || 'Login failed');
                    }
                })
                .catch(error => {
                    console.error('Login error:', error);
                    Alpine.store('loginError', 'An error occurred. Please try again.');
                });
        }

        function handleRegister(event) {
            const form = event.target;
            const formData = new FormData(form);

            fetch('{{ route('register') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        Alpine.store('registerError', data.message || 'Registration failed');
                    }
                })
                .catch(error => {
                    console.error('Register error:', error);
                    Alpine.store('registerError', 'An error occurred. Please try again.');
                });
        }

        function submitCheckout() {
            document.getElementById('checkout-form').submit();
        }

        function scrollToForm(formId) {
            setTimeout(() => {
                const element = document.getElementById(formId);
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 100); // Small delay to allow Alpine transition to start
        }
    </script>
@endsection