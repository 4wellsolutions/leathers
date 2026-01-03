<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = \App\Models\User::value('id') ?? 1;

        Blog::create([
            'blog_category_id' => 1,
            'author_id' => $authorId,
            'title' => 'How to Style a Leather Belt',
            'slug' => 'how-to-style-leather-belt',
            'excerpt' => 'Learn the art of matching your leather belt with different outfits.',
            'content' => '<p>A leather belt is more than just a functional accessory - it is a statement piece that can elevate your entire outfit. Here are our top tips for styling leather belts...</p><p>1. Match your belt to your shoes<br>2. Choose the right width<br>3. Consider the occasion</p>',
            'featured_image' => 'https://placehold.co/1200x600/8B4513/FFFFFF/png?text=Belt+Styling',
            'is_published' => true,
            'published_at' => now()->subDays(5),
        ]);

        Blog::create([
            'blog_category_id' => 2,
            'author_id' => $authorId,
            'title' => 'Ultimate Leather Care Guide',
            'slug' => 'ultimate-leather-care-guide',
            'excerpt' => 'Keep your leather products looking brand new with these essential care tips.',
            'content' => '<p>Proper leather care ensures your products last for years. Follow these essential tips...</p><p><strong>Regular Cleaning:</strong> Wipe with a damp cloth weekly.<br><strong>Conditioning:</strong> Apply leather conditioner monthly.<br><strong>Storage:</strong> Keep in a cool, dry place.</p>',
            'featured_image' => 'https://placehold.co/1200x600/654321/FFFFFF/png?text=Leather+Care',
            'is_published' => true,
            'published_at' => now()->subDays(10),
        ]);

        Blog::create([
            'blog_category_id' => 1,
            'author_id' => $authorId,
            'title' => 'Top 5 Wallet Styles for 2024',
            'slug' => 'top-5-wallet-styles-2024',
            'excerpt' => 'Discover the hottest wallet trends this year.',
            'content' => '<p>From minimalist card holders to classic bifolds, here are the must-have wallet styles for 2024...</p><p>1. Minimalist Card Holders<br>2. RFID-Blocking Wallets<br>3. Long Wallets<br>4. Money Clips<br>5. Zip-Around Wallets</p>',
            'featured_image' => 'https://placehold.co/1200x600/8B7355/FFFFFF/png?text=Wallet+Trends',
            'is_published' => true,
            'published_at' => now()->subDays(3),
        ]);

        Blog::create([
            'blog_category_id' => 3,
            'author_id' => $authorId,
            'title' => 'Review: Classic Leather Belt',
            'slug' => 'review-classic-leather-belt',
            'excerpt' => 'An in-depth review of our bestselling Classic Leather Belt.',
            'content' => '<p>After 6 months of daily wear, here is our honest review of the Classic Leather Belt...</p><p><strong>Pros:</strong> Durable, versatile, premium quality<br><strong>Cons:</strong> Requires break-in period<br><strong>Verdict:</strong> Highly recommended for everyday use.</p>',
            'featured_image' => 'https://placehold.co/1200x600/2F4F4F/FFFFFF/png?text=Belt+Review',
            'is_published' => true,
            'published_at' => now()->subDays(7),
        ]);

        Blog::create([
            'blog_category_id' => 4,
            'author_id' => $authorId,
            'title' => 'New Collection Launch',
            'slug' => 'new-collection-launch',
            'excerpt' => 'Introducing our latest collection of premium leather goods.',
            'content' => '<p>We are excited to announce the launch of our new collection featuring innovative designs and sustainable materials...</p>',
            'featured_image' => 'https://placehold.co/1200x600/696969/FFFFFF/png?text=New+Collection',
            'is_published' => true,
            'published_at' => now()->subDays(1),
        ]);
    }
}
