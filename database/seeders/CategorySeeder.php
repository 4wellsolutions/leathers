<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Belts',
                'slug' => 'belts',
                'description' => 'Premium leather belts for every occasion',
                'image' => 'https://placehold.co/800x600/8B4513/FFFFFF/png?text=Belts',
                'meta_title' => 'Leather Belts | Leathers.pk',
                'meta_description' => 'Shop premium genuine leather belts in Pakistan',
            ],
            [
                'name' => 'Wallets',
                'slug' => 'wallets',
                'description' => 'Handcrafted leather wallets',
                'image' => 'https://placehold.co/800x600/654321/FFFFFF/png?text=Wallets',
                'meta_title' => 'Leather Wallets | Leathers.pk',
                'meta_description' => 'Explore our collection of genuine leather wallets',
            ],
            [
                'name' => 'Watches',
                'slug' => 'watches',
                'description' => 'Elegant watches with leather straps',
                'image' => 'https://placehold.co/800x600/2F4F4F/FFFFFF/png?text=Watches',
                'meta_title' => 'Watches | Leathers.pk',
                'meta_description' => 'Classic leather strap watches for men',
            ],
            [
                'name' => 'Bags',
                'slug' => 'bags',
                'description' => 'Stylish leather bags and accessories',
                'image' => 'https://placehold.co/800x600/8B7355/FFFFFF/png?text=Bags',
                'meta_title' => 'Leather Bags | Leathers.pk',
                'meta_description' => 'Premium leather bags and messenger bags',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
