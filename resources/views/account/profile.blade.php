@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row gap-4 md:gap-8 items-start">

            <!-- Sidebar -->
            @include('partials.account-sidebar')

            <!-- Main Content -->
            <div class="flex-1 w-full">
                <h1 class="text-3xl font-serif font-bold text-leather-900 mb-8">My Profile</h1>

                <!-- Feedback Area -->
                <div id="ajax-feedback" class="mb-6 hidden rounded-lg p-4"></div>
                <form id="profile-form" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="bg-white rounded-xl shadow-lg border border-neutral-100 overflow-hidden">

                        <!-- Personal Details -->
                        <div class="p-6 md:p-8 border-b border-neutral-200">
                            <!-- ... existing content ... -->
                            <h2 class="text-xl font-bold text-leather-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gold-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Personal Details
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-bold text-neutral-900 mb-2">Full
                                        Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-gold-500 focus:ring focus:ring-gold-200 transition-shadow bg-white"
                                        placeholder="Your Name">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-bold text-neutral-900 mb-2">Phone
                                        Number</label>
                                    <input type="text" value="{{ $user->phone }}" disabled
                                        class="w-full px-4 py-3 rounded-lg border border-neutral-200 bg-neutral-100 text-neutral-500 cursor-not-allowed"
                                        title="Phone number cannot be changed directly">
                                    <p class="mt-1 text-xs text-neutral-500">Contact support to update phone</p>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-bold text-neutral-900 mb-2">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        required
                                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-gold-500 focus:ring focus:ring-gold-200 transition-shadow bg-white"
                                        placeholder="your@email.com">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-bold text-neutral-900 mb-2">Delivery
                                        Address</label>
                                    <textarea name="address" id="address" rows="3" required
                                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-gold-500 focus:ring focus:ring-gold-200 transition-shadow bg-white"
                                        placeholder="House #, Street, Area">{{ old('address', $user->address) }}</textarea>
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-bold text-neutral-900 mb-2">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}" required
                                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-gold-500 focus:ring focus:ring-gold-200 transition-shadow bg-white"
                                        placeholder="Lahore">
                                </div>
                            </div>
                        </div>

                        <!-- Security -->
                        <div class="p-6 md:p-8 bg-neutral-50/30">
                            <!-- ... existing content ... -->
                            <h2 class="text-xl font-bold text-leather-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gold-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Change Password
                            </h2>
                            <p class="text-sm text-neutral-500 mb-6">Leave blank if you don't want to change your password.
                            </p>

                            <div class="max-w-xl space-y-6">
                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-bold text-neutral-700 mb-2">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-gold-500 focus:ring focus:ring-gold-200 transition-shadow bg-white">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="new_password" class="block text-sm font-bold text-neutral-700 mb-2">New
                                            Password</label>
                                        <input type="password" name="new_password" id="new_password"
                                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-gold-500 focus:ring focus:ring-gold-200 transition-shadow bg-white">
                                    </div>

                                    <div>
                                        <label for="new_password_confirmation"
                                            class="block text-sm font-bold text-neutral-700 mb-2">Confirm New
                                            Password</label>
                                        <input type="password" name="new_password_confirmation"
                                            id="new_password_confirmation"
                                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-gold-500 focus:ring focus:ring-gold-200 transition-shadow bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="px-6 py-4 bg-neutral-50 border-t border-neutral-100 flex justify-end">
                            <button type="submit" id="save-btn"
                                class="px-6 py-2.5 bg-leather-900 text-white font-bold rounded-lg hover:bg-gold-600 transition-colors shadow-lg shadow-neutral-200 hover:shadow-gold-200 transform hover:-translate-y-0.5 active:translate-y-0 duration-200 flex items-center">
                                <span id="btn-text">Save Changes</span>
                                <svg id="btn-spinner" class="animate-spin ml-2 h-4 w-4 text-white hidden"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>

                <script>
                    document.getElementById('profile-form').addEventListener('submit', async function (e) {
                        e.preventDefault();

                        const form = this;
                        const btn = document.getElementById('save-btn');
                        const btnText = document.getElementById('btn-text');
                        const btnSpinner = document.getElementById('btn-spinner');
                        const feedbackDiv = document.getElementById('ajax-feedback');

                        // Disable button and show spinner
                        btn.disabled = true;
                        btnText.textContent = 'Saving...';
                        btnSpinner.classList.remove('hidden');
                        feedbackDiv.classList.add('hidden');
                        feedbackDiv.className = 'mt-4 hidden rounded-lg p-4'; // Reset classes

                        try {
                            const response = await fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                    'Accept': 'application/json'
                                },
                                body: new FormData(form)
                            });

                            const data = await response.json();

                            feedbackDiv.classList.remove('hidden');

                            if (response.ok) {
                                // Success
                                feedbackDiv.classList.add('bg-green-50', 'text-green-700', 'border', 'border-green-200');
                                feedbackDiv.innerHTML = `
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Profile updated successfully!
                                            </div>
                                        `;
                                setTimeout(() => { feedbackDiv.classList.add('hidden'); }, 5000);
                            } else {
                                // Error
                                feedbackDiv.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-200');
                                let errorMsg = '<ul class="list-disc list-inside text-sm">';
                                if (data.errors) {
                                    Object.values(data.errors).forEach(err => {
                                        errorMsg += '<li>' + err + '</li>';
                                    });
                                } else {
                                    errorMsg += '<li>' + (data.message || 'Something went wrong.') + '</li>';
                                }
                                errorMsg += '</ul>';
                                feedbackDiv.innerHTML = `
                                            <div class="font-bold mb-1">Could not save changes:</div>
                                            ${errorMsg}
                                        `;
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            feedbackDiv.classList.remove('hidden');
                            feedbackDiv.classList.add('bg-red-50', 'text-red-700');
                            feedbackDiv.innerText = 'An unexpected error occurred. Please try again.';
                        } finally {
                            // Reset button
                            btn.disabled = false;
                            btnText.textContent = 'Save Changes';
                            btnSpinner.classList.add('hidden');
                        }
                    });
                </script>
            </div>
        </div>
    </div>
@endsection