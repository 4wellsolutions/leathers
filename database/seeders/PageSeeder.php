<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p>At Leathers.pk, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, and safeguard your personal information when you visit our website.</p><h2>Information We Collect</h2><p>We collect information that you provide to us directly, such as when you create an account, make a purchase, or contact us. This may include your name, email address, shipping address, and payment information.</p><h2>How We Use Your Information</h2><p>We use your information to process your orders, communicate with you about your account and our products, and improve our services.</p><h2>Security</h2><p>We implement a variety of security measures to maintain the safety of your personal information when you place an order or enter, submit, or access your personal information.</p>',
                'meta_title' => 'Privacy Policy - Leathers.pk',
                'meta_description' => 'Read our privacy policy to understand how we handle your personal data.',
                'is_active' => true,
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'content' => '<h1>Terms and Conditions</h1><p>Welcome to Leathers.pk. By accessing or using our website, you agree to be bound by these Terms and Conditions.</p><h2>Use of the Website</h2><p>You may use our website for personal, non-commercial purposes only. You must not use our website for any illegal or unauthorized purpose.</p><h2>Products and Pricing</h2><p>We strive to provide accurate product information and pricing. However, we reserve the right to correct any errors and to change prices without notice.</p><h2>Intellectual Property</h2><p>All content on this website, including text, images, and logos, is the property of Leathers.pk and is protected by intellectual property laws.</p><h2>Limitation of Liability</h2><p>Leathers.pk shall not be liable for any direct, indirect, incidental, or consequential damages arising from your use of the website or purchase of our products.</p>',
                'meta_title' => 'Terms & Conditions - Leathers.pk',
                'meta_description' => 'Read our terms and conditions for using Leathers.pk.',
                'is_active' => true,
            ],
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h1>About Leathers.pk</h1><p>Welcome to Leathers.pk, your premier destination for handcrafted leather goods in Pakistan. Our journey began with a simple passion for the timeless elegance and durability of genuine leather.</p><h2>Our Mission</h2><p>Our mission is to provide modern gentlemen with premium leather products that combine traditional craftsmanship with contemporary design. We believe that every piece of leather tells a story, and we are here to help you craft yours.</p><h2>Quality Craftsmanship</h2><p>Each of our products is meticulously handcrafted by skilled artisans who take pride in their work. We source only the finest genuine leather from top tanneries to ensure that our goods not only look beautiful but also last a lifetime.</p><h2>Our Commitment</h2><p>We are committed to exceptional quality, customer satisfaction, and building a brand that stands for integrity and style.</p>',
                'meta_title' => 'About Us - Leathers.pk',
                'meta_description' => 'Learn more about Leathers.pk, our mission, and our passion for handcrafted leather goods.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
