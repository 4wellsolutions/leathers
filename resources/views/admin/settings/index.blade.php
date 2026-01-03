@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Site Settings</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.cache.index') }}"
                        class="px-4 py-2 bg-neutral-600 text-white rounded-lg hover:bg-neutral-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Cache Management
                    </a>
                    <form action="{{ route('admin.cache.clear-all') }}" method="POST" class="inline"
                        onsubmit="return confirm('Clear all caches?')">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Clear Cache
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                @csrf
                @method('PUT')

                <!-- General Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">General Settings</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Site Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Leathers.pk' }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Site Logo</label>
                        @if(isset($settings['site_logo']))
                            <div class="mb-2">
                                <img src="{{ $settings['site_logo'] }}" alt="Current Logo" class="h-16 mb-2">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p class="text-gray-600 text-xs mt-1">Upload a new logo (optional). Recommended size: 200x60px</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Favicon</label>
                        @if(isset($settings['site_favicon']))
                            <div class="mb-2">
                                <img src="{{ $settings['site_favicon'] }}" alt="Current Favicon" class="h-8 w-8 mb-2">
                            </div>
                        @endif
                        <input type="file" name="favicon" accept="image/x-icon,image/png,image/jpeg"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p class="text-gray-600 text-xs mt-1">Upload a favicon (optional). Recommended: 32x32px .ico or .png
                            file</p>
                    </div>
                </div>

                <!-- Homepage Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Homepage Settings</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Homepage Title</label>
                        <input type="text" name="homepage_title"
                            value="{{ $settings['homepage_title'] ?? 'Premium Handcrafted Leather Goods' }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Homepage Subtitle</label>
                        <textarea name="homepage_subtitle" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $settings['homepage_subtitle'] ?? 'Discover timeless elegance with our collection of premium leather products' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">CTA Button Text</label>
                        <input type="text" name="homepage_cta_text"
                            value="{{ $settings['homepage_cta_text'] ?? 'Shop Now' }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">SEO Settings</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $settings['meta_description'] ?? 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk.' }}</textarea>
                    </div>
                </div>

                <!-- Top Bar Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Top Bar Settings</h2>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Notification Text</label>
                        <input type="text" name="topbar_text"
                            value="{{ $settings['topbar_text'] ?? 'FREE SHIPPING ON ALL ORDERS OVER RS. 5000' }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <!-- Social Media Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Social Media Links</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">WhatsApp Number</label>
                            <input type="text" name="social_whatsapp" value="{{ $settings['social_whatsapp'] ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="e.g. +923001234567">
                            <p class="text-gray-500 text-xs mt-1">Include country code without spaces or dashes.</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Facebook URL</label>
                            <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="https://facebook.com/yourpage">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Instagram URL</label>
                            <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="https://instagram.com/yourpage">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Twitter/X URL</label>
                            <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="https://twitter.com/yourhandle">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">LinkedIn URL</label>
                            <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="https://linkedin.com/company/yourpage">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">YouTube URL</label>
                            <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="https://youtube.com/c/yourchannel">
                        </div>
                    </div>
                </div>

                <!-- Contact Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Contact Information</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Contact Email</label>
                        <input type="email" name="contact_email"
                            value="{{ $settings['contact_email'] ?? 'info@leathers.pk' }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Contact Phone</label>
                        <input type="text" name="contact_phone"
                            value="{{ $settings['contact_phone'] ?? '+92 300 1234567' }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <!-- Notification Email Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">System Notifications</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Notification Email Addresses</label>
                        <textarea name="notification_emails" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('notification_emails') border-red-500 @enderror"
                            placeholder="admin@example.com, sales@example.com, support@example.com">{{ old('notification_emails', $settings['notification_emails'] ?? config('mail.from.address')) }}</textarea>
                        <p class="text-gray-600 text-xs mt-1">Enter email addresses separated by commas. These addresses
                            will receive all system notifications (orders, contact forms, etc.)</p>
                        @error('notification_emails')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!--Social Media --
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Social Media</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Facebook URL</label>
                        <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Instagram URL</label>
                        <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <!-- Custom Scripts -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Custom Scripts</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Header Scripts (CSS/JS)</label>
                        <p class="text-gray-600 text-xs mb-2">These scripts will be added before the closing &lt;/head&gt;
                            tag.</p>
                        <textarea name="header_scripts" rows="5"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline font-mono text-sm">{{ $settings['header_scripts'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Footer Scripts (JS)</label>
                        <p class="text-gray-600 text-xs mb-2">These scripts will be added before the closing &lt;/body&gt;
                            tag.</p>
                        <textarea name="footer_scripts" rows="5"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline font-mono text-sm">{{ $settings['footer_scripts'] ?? '' }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection