@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
    <form action="{{ route('admin.users.store') }}" method="POST" class="pb-20">
        @csrf

        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-10 bg-neutral-100/95 backdrop-blur-sm border-b border-neutral-200 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 py-4 mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-leather-900">Add New User</h1>
                <p class="text-sm text-neutral-500">Create a new user account.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 text-sm font-medium text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-leather-900 border border-transparent rounded-lg hover:bg-leather-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm transition-all transform hover:-translate-y-0.5">
                    Create User
                </button>
            </div>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="p-6 md:p-8 space-y-6">
                    <h2 class="text-lg font-semibold text-leather-900 border-b border-neutral-100 pb-4 mb-6">User Details
                    </h2>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4"
                                placeholder="John Doe">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-neutral-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4"
                                placeholder="+923001234567">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">Email Address <span
                                    class="text-neutral-400 font-normal">(optional)</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4"
                                placeholder="john@example.com">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-neutral-700 mb-2">Password</label>
                                <input type="password" name="password" id="password"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-neutral-700 mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="block w-full rounded-lg border-neutral-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm py-3 px-4">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-neutral-100">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-neutral-900">Administrator Access</span>
                                    <span class="text-xs text-neutral-500">Grant full access to the admin panel</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gold-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gold-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection