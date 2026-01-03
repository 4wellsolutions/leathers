<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Leathers.pk', 'type' => 'text'],
            ['key' => 'site_logo', 'value' => '/images/hero/hero.png', 'type' => 'image'],
            ['key' => 'homepage_title', 'value' => 'Premium Handcrafted Leather Goods', 'type' => 'text'],
            ['key' => 'homepage_subtitle', 'value' => 'Discover timeless elegance with our collection of premium leather products', 'type' => 'text'],
            ['key' => 'homepage_cta_text', 'value' => 'Shop Now', 'type' => 'text'],
            ['key' => 'meta_description', 'value' => 'Shop premium handcrafted leather belts, wallets, and watches at Leathers.pk. Genuine leather products with lifetime warranty. Free shipping on orders over Rs. 5,000.', 'type' => 'textarea'],
            ['key' => 'contact_email', 'value' => 'info@leathers.pk', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+92 300 1234567', 'type' => 'text'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/leatherspk', 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/leatherspk', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
