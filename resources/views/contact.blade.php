@extends('layouts.app')

@section('title', 'Contact Us | Leathers.pk')

@section('content')
<div class="bg-neutral-50 min-h-screen">
    <!-- Premium Hero Section -->
    <div class="relative bg-leather-900 py-24 sm:py-32 overflow-hidden">
        <!-- Abstract Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="#d4af37" />
            </svg>
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-leather-900/90"></div>
        
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-gold-400/10 text-gold-400 text-xs font-bold tracking-widest uppercase mb-4 border border-gold-400/20">Client Support</span>
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl font-serif mb-6">Let's Craft Something <span class="text-gold-400 italic">Personal</span></h1>
            <p class="text-lg leading-8 text-neutral-300 max-w-2xl mx-auto font-light">
                Whether you have a question about our leathers, need help with a custom order, or just want to say hello, we are at your service.
            </p>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="relative z-10 -mt-16 mx-auto max-w-7xl px-6 lg:px-8 pb-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
            
            <!-- Contact Form Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 border-t-4 border-gold-500 my-8">
                <h2 class="text-2xl font-bold text-leather-900 mb-2 font-serif">Send us a Message</h2>
                <p class="text-neutral-500 mb-8 text-sm">Fill out the form below and we'll get back to you within 24 hours.</p>

                <!-- Success Message Container -->
                <div id="success-message" class="hidden mb-8 rounded-lg bg-green-50 p-4 border border-green-100 flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Success</h3>
                        <div class="mt-1 text-sm text-green-700" id="success-text"></div>
                    </div>
                </div>

                <form id="contact-form" action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-leather-900">Name</label>
                            <input type="text" name="name" id="name" autocomplete="name" class="mt-2 block w-full rounded-lg border-0 py-3 px-4 text-leather-900 ring-1 ring-inset ring-neutral-200 placeholder:text-neutral-400 focus:ring-2 focus:ring-inset focus:ring-gold-500 sm:text-sm sm:leading-6 bg-neutral-50 transition-all focus:bg-white" placeholder="John Doe" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-leather-900">Email</label>
                            <input type="email" name="email" id="email" autocomplete="email" class="mt-2 block w-full rounded-lg border-0 py-3 px-4 text-leather-900 ring-1 ring-inset ring-neutral-200 placeholder:text-neutral-400 focus:ring-2 focus:ring-inset focus:ring-gold-500 sm:text-sm sm:leading-6 bg-neutral-50 transition-all focus:bg-white" placeholder="john@example.com" required>
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium leading-6 text-leather-900">Subject</label>
                        <input type="text" name="subject" id="subject" class="mt-2 block w-full rounded-lg border-0 py-3 px-4 text-leather-900 ring-1 ring-inset ring-neutral-200 placeholder:text-neutral-400 focus:ring-2 focus:ring-inset focus:ring-gold-500 sm:text-sm sm:leading-6 bg-neutral-50 transition-all focus:bg-white" placeholder="How can we help?" required>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium leading-6 text-leather-900">Message</label>
                        <textarea name="message" id="message" rows="5" class="mt-2 block w-full rounded-lg border-0 py-3 px-4 text-leather-900 ring-1 ring-inset ring-neutral-200 placeholder:text-neutral-400 focus:ring-2 focus:ring-inset focus:ring-gold-500 sm:text-sm sm:leading-6 bg-neutral-50 transition-all focus:bg-white" placeholder="Tell us more about your inquiry..." required></textarea>
                    </div>
                    <div>
                        <button type="submit" id="submit-btn" class="group relative flex w-full justify-center rounded-lg bg-leather-900 px-6 py-4 text-sm font-semibold text-white hover:bg-leather-800 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold-600 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 duration-200 disabled:opacity-75 disabled:cursor-not-allowed">
                            <span id="btn-text">Send Message</span>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" id="btn-arrow">→</span>
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" id="btn-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Info & FAQ -->
            <div class="pt-8 lg:pt-16 space-y-12">
                <!-- Info Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-100 hover:shadow-md transition-shadow group h-full">
                        <div class="h-10 w-10 bg-gold-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-gold-500 transition-colors duration-300">
                            <svg class="h-5 w-5 text-gold-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-leather-900 mb-1">Email Us</h3>
                        <p class="text-sm text-neutral-500 mb-3">We reply within 24 hours</p>
                        <a href="mailto:hello@leathers.pk" class="text-sm font-medium text-gold-600 hover:text-gold-700 flex items-center">
                            hello@leathers.pk
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-100 hover:shadow-md transition-shadow group h-full">
                        <div class="h-10 w-10 bg-gold-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-gold-500 transition-colors duration-300">
                            <svg class="h-5 w-5 text-gold-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-leather-900 mb-1">Call Us</h3>
                        <p class="text-sm text-neutral-500 mb-3">Mon-Sat from 9am to 6pm</p>
                        <a href="tel:+923001234567" class="text-sm font-medium text-gold-600 hover:text-gold-700">
                            +92 300 123 4567
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-100 hover:shadow-md transition-shadow group h-full">
                        <div class="h-10 w-10 bg-gold-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-gold-500 transition-colors duration-300">
                            <svg class="h-5 w-5 text-gold-600 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </div>
                        <h3 class="font-bold text-leather-900 mb-1">WhatsApp</h3>
                        <p class="text-sm text-neutral-500 mb-3">Chat with us</p>
                        @php
                            $whatsapp = \App\Models\Setting::get('social_whatsapp') ?? '+923001234567';
                        @endphp
                        <a href="https://wa.me/{{ str_replace(['+', ' '], '', $whatsapp) }}" target="_blank" class="text-sm font-medium text-gold-600 hover:text-gold-700">
                             {{ $whatsapp }}
                        </a>
                    </div>
                </div>

                <!-- Connect with Us -->
                <div>
                    <h3 class="text-xl font-bold text-leather-900 font-serif mb-6">Connect with Us</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <a href="{{ \App\Models\Setting::get('social_facebook') ?? '#' }}" target="_blank" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-neutral-100 hover:shadow-md hover:border-blue-200 hover:bg-blue-50 transition-all duration-300 group">
                            <svg class="h-6 w-6 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            <span class="text-xs font-bold text-neutral-600 group-hover:text-blue-700">Facebook</span>
                        </a>

                        <a href="{{ \App\Models\Setting::get('social_instagram') ?? '#' }}" target="_blank" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-neutral-100 hover:shadow-md hover:border-pink-200 hover:bg-pink-50 transition-all duration-300 group">
                            <svg class="h-6 w-6 text-pink-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.584-.012-4.849-.069-3.225-.149-4.771-1.664-4.919-4.919-.058-1.265-.069-1.644-.069-4.849 0-3.204.012-3.584.069-4.849.149-3.225 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            <span class="text-xs font-bold text-neutral-600 group-hover:text-pink-700">Instagram</span>
                        </a>

                        <a href="{{ \App\Models\Setting::get('social_twitter') ?? '#' }}" target="_blank" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-neutral-100 hover:shadow-md hover:border-gray-400 hover:bg-gray-50 transition-all duration-300 group">
                            <svg class="h-6 w-6 text-gray-800 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            <span class="text-xs font-bold text-neutral-600 group-hover:text-gray-900">X (Twitter)</span>
                        </a>

                        <a href="{{ \App\Models\Setting::get('social_linkedin') ?? '#' }}" target="_blank" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-neutral-100 hover:shadow-md hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group">
                            <svg class="h-6 w-6 text-blue-700 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            <span class="text-xs font-bold text-neutral-600 group-hover:text-blue-800">LinkedIn</span>
                        </a>

                        <a href="{{ \App\Models\Setting::get('social_youtube') ?? '#' }}" target="_blank" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-neutral-100 hover:shadow-md hover:border-red-200 hover:bg-red-50 transition-all duration-300 group">
                            <svg class="h-6 w-6 text-red-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            <span class="text-xs font-bold text-neutral-600 group-hover:text-red-700">YouTube</span>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const btn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnArrow = document.getElementById('btn-arrow');
        const btnSpinner = document.getElementById('btn-spinner');
        const successMsg = document.getElementById('success-message');
        const successText = document.getElementById('success-text');

        // Loading state
        btn.disabled = true;
        btnText.classList.add('opacity-0');
        btnArrow.classList.add('hidden');
        btnSpinner.classList.remove('hidden');

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json().catch(() => ({ message: 'Something went wrong.' }))) // Handle JSON parsing errors
        .then(data => {
            // Reset button
            btn.disabled = false;
            btnText.classList.remove('opacity-0');
            btnArrow.classList.remove('hidden');
            btnSpinner.classList.add('hidden');

            if (data.success || data.message) {
                 successText.textContent = 'Thank you for contacting us! We will get back to you soon.';
                 successMsg.classList.remove('hidden');
                 form.reset();
                 // Scroll to success message
                 successMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                 alert('Something went wrong. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btnText.classList.remove('opacity-0');
            btnArrow.classList.remove('hidden');
            btnSpinner.classList.add('hidden');
            alert('An error occurred. Please try again.');
        });
    });
</script>
@endsection
