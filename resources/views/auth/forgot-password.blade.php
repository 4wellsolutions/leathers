@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex" x-data="forgotPassword()">
    <!-- Left Side - Image -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <img src="{{ asset('/images/hero/hero.png') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-leather-900/40 backdrop-blur-[2px]"></div>
        <div class="absolute inset-0 flex flex-col justify-center px-12 text-white">
            <h2 class="text-4xl font-serif font-bold mb-6" x-text="titles[step]">Forgot Password?</h2>
            <p class="text-lg text-neutral-200 max-w-md" x-text="descriptions[step]">No worries! Enter your email and we'll send you a One-Time Password (OTP) to reset it.</p>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-white">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center lg:text-left">
                <h2 class="text-3xl font-serif font-bold text-leather-900" x-text="titles[step]">Reset Password</h2>
                <p class="mt-2 text-sm text-neutral-600" x-show="step === 1">
                    Remember your password? <a href="{{ route('login') }}" class="font-medium text-gold-600 hover:text-gold-500 transition-colors">Back to Login</a>
                </p>
                <p class="mt-2 text-sm text-neutral-600" x-show="step === 2">
                    Code sent to <span class="font-semibold" x-text="email"></span>
                </p>
            </div>

            <!-- Error Message -->
            <div x-show="errorMessage" x-transition class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <p x-text="errorMessage"></p>
            </div>

            <!-- Success Message -->
            <div x-show="successMessage" x-transition class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <p x-text="successMessage"></p>
            </div>

            <!-- Step 1: Email Form -->
            <form x-show="step === 1" @submit.prevent="sendOtp" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">Email address</label>
                    <input x-model="email" type="email" required 
                        class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm" 
                        placeholder="Enter your email">
                </div>
                <button type="submit" :disabled="loading" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Send OTP</span>
                    <span x-show="loading">Sending...</span>
                </button>
            </form>

            <!-- Step 2: Verify OTP Form -->
            <form x-show="step === 2" @submit.prevent="verifyOtp" class="space-y-6">
                <div>
                    <label for="otp" class="block text-sm font-medium text-neutral-700 mb-1">One-Time Password</label>
                    <input x-model="otp" type="text" required maxlength="6"
                        class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm tracking-widest text-center text-2xl" 
                        placeholder="123456">
                </div>
                <button type="submit" :disabled="loading" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Verify & Proceed</span>
                    <span x-show="loading">Verifying...</span>
                </button>
                <div class="text-center">
                    <button type="button" @click="step = 1" class="text-sm font-medium text-gold-600 hover:text-gold-500">Change Email</button>
                </div>
            </form>

            <!-- Step 3: Reset Password Form -->
            <form x-show="step === 3" @submit.prevent="resetPassword" class="space-y-6">
                <div class="space-y-5">
                    <div>
                        <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">New Password</label>
                        <input x-model="password" type="password" required 
                            class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm" 
                            placeholder="Enter new password">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-1">Confirm Password</label>
                        <input x-model="password_confirmation" type="password" required 
                            class="appearance-none block w-full px-4 py-3 border border-neutral-300 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors sm:text-sm" 
                            placeholder="Confirm new password">
                    </div>
                </div>
                <button type="submit" :disabled="loading" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Reset Password</span>
                    <span x-show="loading">Resetting...</span>
                </button>
            </form>
            
            <!-- Success State -->
            <div x-show="step === 4" class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Password Reset Successful</h3>
                <p class="mt-2 text-sm text-gray-500">Your password has been updated. You can now login with your new password.</p>
                <div class="mt-6">
                    <a href="{{ route('login') }}" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-leather-900 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-all">
                        Go to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function forgotPassword() {
        return {
            step: 1,
            email: '',
            otp: '',
            token: '',
            password: '',
            password_confirmation: '',
            loading: false,
            errorMessage: '',
            successMessage: '',
            titles: {
                1: 'Forgot Password?',
                2: 'Verify OTP',
                3: 'Reset Password',
                4: 'Success'
            },
            descriptions: {
                1: "No worries! Enter your email and we'll send you a One-Time Password (OTP) to reset it.",
                2: "Please enter the 6-digit code sent to your email address.",
                3: "Create a new strong password for your account.",
                4: "Your password has been successfully reset."
            },

            async sendOtp() {
                this.loading = true;
                this.errorMessage = '';
                
                try {
                    const response = await fetch('{{ route("password.email") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: this.email })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        this.step = 2;
                        this.successMessage = data.message;
                        setTimeout(() => this.successMessage = '', 3000);
                    } else {
                        this.errorMessage = data.message || (data.errors ? Object.values(data.errors).flat()[0] : 'An error occurred');
                    }
                } catch (error) {
                    this.errorMessage = 'Network error. Please try again.';
                } finally {
                    this.loading = false;
                }
            },

            async verifyOtp() {
                this.loading = true;
                this.errorMessage = '';
                
                try {
                    const response = await fetch('{{ route("password.verify.post") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            email: this.email,
                            otp: this.otp
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        this.token = data.token;
                        this.step = 3;
                        this.successMessage = 'OTP Verified';
                        setTimeout(() => this.successMessage = '', 3000);
                    } else {
                        this.errorMessage = data.message || (data.errors ? Object.values(data.errors).flat()[0] : 'Invalid OTP');
                    }
                } catch (error) {
                    this.errorMessage = 'Network error. Please try again.';
                } finally {
                    this.loading = false;
                }
            },

            async resetPassword() {
                this.loading = true;
                this.errorMessage = '';
                
                try {
                    const response = await fetch('{{ route("password.update") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            email: this.email,
                            token: this.token,
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        this.step = 4;
                    } else {
                        this.errorMessage = data.message || (data.errors ? Object.values(data.errors).flat()[0] : 'An error occurred');
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
