<footer class="bg-leather-900 text-neutral-300 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- Brand Info -->
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="font-serif text-2xl font-bold text-gold-400 tracking-wider block">
                    LEATHERS<span class="text-white">.PK</span>
                </a>
                <p class="text-sm leading-relaxed text-neutral-400">
                    Crafting premium leather goods for the modern gentleman. Timeless designs, exceptional quality, and unmatched durability.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-gold-400 font-serif font-bold text-lg mb-6">Quick Links</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Shop All Products</a></li>
                    <li><a href="{{ route('pages.show', 'about-us') }}" class="hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">The Journal</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a></li>
                    <li><a href="{{ route('pages.show', 'privacy-policy') }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="{{ route('pages.show', 'terms-and-conditions') }}" class="hover:text-white transition-colors">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div>
                <h3 class="text-gold-400 font-serif font-bold text-lg mb-6">Collections</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('category.show', 'leather-belts') }}" class="hover:text-white transition-colors">Leather Belts</a></li>
                    <li><a href="{{ route('category.show', 'leather-wallets') }}" class="hover:text-white transition-colors">Leather Wallets</a></li>
                    <li><a href="{{ route('category.show', 'leather-watches') }}" class="hover:text-white transition-colors">Leather Watches</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">New Arrivals</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Gift Sets</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-gold-400 font-serif font-bold text-lg mb-6">Newsletter</h3>
                <p class="text-sm text-neutral-400 mb-4">Subscribe to receive updates, access to exclusive deals, and more.</p>
                <form class="space-y-2">
                    <input type="email" placeholder="Enter your email" class="w-full bg-leather-800 border border-leather-700 rounded-md px-4 py-2 text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-gold-500 focus:border-gold-500">
                    <button type="submit" class="w-full bg-gold-500 hover:bg-gold-600 text-leather-900 font-bold py-2 rounded-md transition-colors duration-300">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="border-t border-leather-800 mt-12 pt-8 text-center text-xs text-neutral-500">
            <p>&copy; {{ date('Y') }} Leathers.pk. All rights reserved.</p>
        </div>
    </div>
</footer>
