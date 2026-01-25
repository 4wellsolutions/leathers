@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-neutral-50">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-serif font-bold text-leather-900">Create your account</h2>
                <p class="mt-2 text-center text-sm text-neutral-600">
                    Already have an account? <a href="{{ route('login') }}"
                        class="font-medium text-gold-600 hover:text-gold-500">Sign in</a>
                </p>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="name" class="sr-only">Full Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-neutral-300 placeholder-neutral-500 text-leather-900 rounded-t-md focus:outline-none focus:ring-gold-500 focus:border-gold-500 focus:z-10 sm:text-sm"
                            placeholder="Full Name">
                    </div>
                    <div>
                        <label for="phone" class="sr-only">Phone Number</label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-neutral-300 placeholder-neutral-500 text-leather-900 focus:outline-none focus:ring-gold-500 focus:border-gold-500 focus:z-10 sm:text-sm"
                            placeholder="Phone Number">
                    </div>
                    <div>
                        <label for="email-address" class="sr-only">Email address (Optional)</label>
                        <input id="email-address" name="email" type="email" autocomplete="email"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-neutral-300 placeholder-neutral-500 text-leather-900 focus:outline-none focus:ring-gold-500 focus:border-gold-500 focus:z-10 sm:text-sm"
                            placeholder="Email address (Optional)">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-neutral-300 placeholder-neutral-500 text-leather-900 focus:outline-none focus:ring-gold-500 focus:border-gold-500 focus:z-10 sm:text-sm"
                            placeholder="Password">
                    </div>
                    <div>
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-neutral-300 placeholder-neutral-500 text-leather-900 rounded-b-md focus:outline-none focus:ring-gold-500 focus:border-gold-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm Password">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-leather-700 hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors duration-300">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gold-500 group-hover:text-gold-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection