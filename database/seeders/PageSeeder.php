<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => '<h1>About Leathers.pk</h1><p>Welcome to Pakistan\'s premier destination for authentic leather goods. Since 2020, we\'ve been crafting premium leather products that combine traditional craftsmanship with modern design.</p><p>Our mission is to provide high-quality, durable leather accessories that stand the test of time.</p>',
            'meta_title' => 'About Us | Leathers.pk',
            'meta_description' => 'Learn about Leathers.pk - Pakistan\'s trusted source for premium leather goods',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Contact Us',
            'slug' => 'contact',
            'content' => '<h1>Get in Touch</h1><p><strong>Email:</strong> hello@leathers.pk<br><strong>Phone:</strong> +92 300 1234567<br><strong>Address:</strong> Lahore, Pakistan</p><p>Business Hours: Monday - Saturday, 10 AM - 8 PM</p>',
            'meta_title' => 'Contact Us | Leathers.pk',
            'meta_description' => 'Get in touch with Leathers.pk for inquiries and support',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us. This policy outlines how we collect, use, and protect your personal information.</p><h2>Information We Collect</h2><p>We collect information you provide directly, such as name, email, and shipping address.</p><h2>How We Use Your Information</h2><p>We use your information to process orders, improve our services, and communicate with you.</p>',
            'meta_title' => 'Privacy Policy | Leathers.pk',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Terms& Conditions',
            'slug' => 'terms-conditions',
            'content' => '<h1>Terms & Conditions</h1><p>By accessing and using Leathers.pk, you agree to these terms and conditions.</p><h2>Use of Website</h2><p>You may use our website for lawful purposes only.</p><h2>Product Information</h2><p>We strive to provide accurate product information but cannot guarantee complete accuracy.</p>',
            'meta_title' => 'Terms & Conditions | Leathers.pk',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Shipping Policy',
            'slug' => 'shipping-policy',
            'content' => '<h1>Shipping Policy</h1><p>We offer shipping across Pakistan with the following rates:</p><ul><li>Free shipping on orders over Rs. 5,000</li><li>Standard delivery: Rs. 200 (3-5 business days)</li><li>Express delivery: Rs. 400 (1-2 business days)</li></ul><p>Orders are processed within 24 hours.</p>',
            'meta_title' => 'Shipping Policy | Leathers.pk',
            'is_active' => true,
        ]);

        Page::create([
            'title' => 'Return Policy',
            'slug' => 'return-policy',
            'content' => '<h1>Return & Exchange Policy</h1><p>We want you to be completely satisfied with your purchase.</p><h2>Returns</h2><p>Items can be returned within 7 days of delivery in original condition.</p><h2>Exchanges</h2><p>Free exchanges for size or color within 14 days.</p><h2>Refunds</h2><p>Refunds are processed within 5-7 business days.</p>',
            'meta_title' => 'Return Policy | Leathers.pk',
            'is_active' => true,
        ]);
    }
}
