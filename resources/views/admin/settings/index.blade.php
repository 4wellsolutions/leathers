@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="max-w-5xl mx-auto space-y-6">
                <!-- Sticky Header -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sticky top-0 z-10 bg-neutral-100/95 backdrop-blur py-4 border-b border-neutral-200">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
                        <p class="text-sm text-gray-500">Manage your website's core configuration and identity</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.cache.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Cache
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your
                                    submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Brand Identity -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                        <h2 class="text-lg font-semibold text-gray-900">Brand Identity</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Logo, favicon, and site naming</p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Leathers.pk' }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-11 px-4">
                        </div>

                        <!-- Logo Section -->
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Site Logo</label>

                            <div class="flex items-start space-x-6">
                                <div class="flex-shrink-0">
                                    @if(isset($settings['site_logo']))
                                        <div class="p-3 bg-neutral-100 rounded-lg border border-neutral-200 inline-block">
                                            <img src="{{ asset($settings['site_logo']) }}" alt="Current Logo"
                                                class="h-16 object-contain">
                                        </div>
                                    @else
                                        <div
                                            class="h-24 w-40 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-400">
                                            No Logo
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 space-y-2">
                                    <input type="file" name="logo" accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors">
                                    <p class="text-xs text-gray-500">Recommended size: 200x60px. Supports PNG, JPG, SVG.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Favicon Section -->
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Favicon</label>

                            <div class="flex items-start space-x-6">
                                <div class="flex-shrink-0">
                                    @if(isset($settings['site_favicon']))
                                        <div class="p-3 bg-neutral-100 rounded-lg border border-neutral-200 inline-block">
                                            <img src="{{ asset($settings['site_favicon']) }}" alt="Favicon"
                                                class="h-8 w-8 object-contain">
                                        </div>
                                    @else
                                        <div
                                            class="h-16 w-16 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-400">
                                            <span class="text-xs">ico</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 space-y-2">
                                    <input type="file" name="favicon" accept="image/x-icon,image/png,image/jpeg"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100 transition-colors">
                                    <p class="text-xs text-gray-500">Recommended: 32x32px .ico or .png file</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Homepage Settings -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                        <h2 class="text-lg font-semibold text-gray-900">Homepage Content</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Customize your main landing page text</p>
                    </div>

                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Headline Title</label>
                            <input type="text" name="homepage_title"
                                value="{{ $settings['homepage_title'] ?? 'Premium Handcrafted Leather Goods' }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-11">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle / Tagline</label>
                            <textarea name="homepage_subtitle" rows="2"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm">{{ $settings['homepage_subtitle'] ?? 'Discover timeless elegance with our collection of premium leather products' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CTA Button Text</label>
                            <input type="text" name="homepage_cta_text"
                                value="{{ $settings['homepage_cta_text'] ?? 'Shop Now' }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-11">
                        </div>
                    </div>
                </div>

                <!-- Contact & Social -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Contact Info -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden h-full">
                        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                            <h2 class="text-lg font-semibold text-gray-900">Contact Information</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Support Email</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email" name="contact_email"
                                        value="{{ $settings['contact_email'] ?? 'info@leathers.pk' }}"
                                        class="focus:ring-gold-500 focus:border-gold-500 block w-full pl-14 sm:text-sm border-gray-300 rounded-lg h-11">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Support Phone</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="contact_phone"
                                        value="{{ $settings['contact_phone'] ?? '+92 300 1234567' }}"
                                        class="focus:ring-gold-500 focus:border-gold-500 block w-full pl-14 sm:text-sm border-gray-300 rounded-lg h-11">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="social_whatsapp"
                                        value="{{ $settings['social_whatsapp'] ?? '' }}"
                                        class="focus:ring-gold-500 focus:border-gold-500 block w-full pl-14 sm:text-sm border-gray-300 rounded-lg h-11"
                                        placeholder="+923001234567">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden h-full">
                        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                            <h2 class="text-lg font-semibold text-gray-900">Social Profiles</h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Facebook</label>
                                <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-10"
                                    placeholder="https://facebook.com/yourpage">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Instagram</label>
                                <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-10"
                                    placeholder="https://instagram.com/yourpage">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Twitter
                                    / X</label>
                                <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-10"
                                    placeholder="https://twitter.com/yourhandle">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">LinkedIn</label>
                                <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-10"
                                    placeholder="https://linkedin.com/company/yourpage">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">YouTube</label>
                                <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-10"
                                    placeholder="https://youtube.com/c/yourchannel">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-10">
                    <!-- SEO & Notices -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                            <h2 class="text-lg font-semibold text-gray-900">SEO & Notifications</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                                <textarea name="meta_description" rows="3"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm">{{ $settings['meta_description'] ?? 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk.' }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Top Bar Notification</label>
                                <input type="text" name="topbar_text"
                                    value="{{ $settings['topbar_text'] ?? 'FREE SHIPPING ON ALL ORDERS OVER RS. 5000' }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm h-11">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Admin Notication Emails</label>
                                <textarea name="notification_emails" rows="2"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm @error('notification_emails') border-red-500 @enderror"
                                    placeholder="admin@example.com, sales@example.com">{{ old('notification_emails', $settings['notification_emails'] ?? config('mail.from.address')) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Comma-separated emails for system alerts.</p>
                                @error('notification_emails')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Scripts -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                            <h2 class="text-lg font-semibold text-gray-900">Custom Scripts</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Header Scripts
                                    &lt;head&gt;</label>
                                <textarea name="header_scripts" rows="4"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm font-mono text-xs bg-gray-50">{{ $settings['header_scripts'] ?? '' }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Footer Scripts
                                    &lt;/body&gt;</label>
                                <textarea name="footer_scripts" rows="4"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500 sm:text-sm font-mono text-xs bg-gray-50">{{ $settings['footer_scripts'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Save Button (Optional secondary) -->
                <div class="flex justify-end pb-8">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                        Save All Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection