<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class LargeScaleProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Belts' => [
                'id' => 1,
                'images' => ['/images/products/belt-brown.png', '/images/products/belt-black.png'],
                'adjectives' => ['Classic', 'Premium', 'Executive', 'Vintage', 'Modern', 'Slim', 'Heavy-Duty', 'Woven', 'Reversible', 'Casual'],
                'materials' => ['Full-Grain', 'Top-Grain', 'Suede', 'Nubuck', 'Textured'],
            ],
            'Wallets' => [
                'id' => 2,
                'images' => ['/images/products/wallet-black.png', '/images/products/wallet-brown.png'],
                'adjectives' => ['Slim', 'Bifold', 'Trifold', 'Minimalist', 'Travel', 'Cardholder', 'Zippered', 'Luxury', 'Everyday', 'Compact'],
                'materials' => ['Italian', 'Cowhide', 'Buffalo', 'Vegetable-Tanned', 'Distressed'],
            ],
            'Watches' => [
                'id' => 3,
                'images' => ['/images/products/watch-brown.png'],
                'adjectives' => ['Chronograph', 'Automatic', 'Quartz', 'Minimalist', 'Sport', 'Dress', 'Aviator', 'Diver', 'Field', 'Luxury'],
                'materials' => ['Stainless Steel', 'Titanium', 'Gold-Plated', 'Rose Gold', 'Silver'],
            ],
        ];

        foreach ($categories as $categoryName => $data) {
            $count = ($categoryName === 'Watches') ? 20 : 40; // 40 Belts, 40 Wallets, 20 Watches

            for ($i = 0; $i < $count; $i++) {
                $adjective = $data['adjectives'][array_rand($data['adjectives'])];
                $material = $data['materials'][array_rand($data['materials'])];
                $color = ['Black', 'Brown', 'Tan', 'Cognac', 'Navy'][rand(0, 4)];
                
                $name = "$adjective $material $categoryName - $color";
                // Ensure unique name by appending a random number if needed
                if (Product::where('name', $name)->exists()) {
                    $name .= ' ' . rand(100, 999);
                }

                if (Product::where('name', $name)->exists()) {
                    continue;
                }

                $price = rand(2000, 15000);
                $salePrice = (rand(0, 10) > 7) ? $price * 0.8 : null; // 30% chance of sale
                
                // Generate 2-4 additional product images
                $additionalImages = [];
                $imageCount = rand(2, 4);
                for ($j = 0; $j < $imageCount; $j++) {
                    $additionalImages[] = $data['images'][array_rand($data['images'])];
                }

                Product::create([
                    'category_id' => $data['id'],
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => "Experience the epitome of style and durability with our $name. Handcrafted from the finest materials, this piece is designed to elevate your everyday look. Features premium stitching and high-quality hardware.",
                    'details' => "<h3>Product Specifications</h3>
<ul>
    <li><strong>Material:</strong> Genuine Leather</li>
    <li><strong>Color:</strong> $color</li>
    <li><strong>Origin:</strong> Handcrafted in Pakistan</li>
    <li><strong>Warranty:</strong> Lifetime Warranty on Leather</li>
</ul>
<p>Care Instructions: Clean with a soft, dry cloth. Avoid exposure to water and direct sunlight.</p>",
                    'price' => $price,
                    'sale_price' => $salePrice,
                    'image' => $data['images'][array_rand($data['images'])],
                    'images' => $additionalImages,
                    'stock' => rand(5, 100),
                    'featured' => (rand(0, 10) > 8), // 20% chance of being featured
                    'is_active' => true,
                    'meta_title' => "$name - Premium Leather Goods | Leathers.pk",
                    'meta_description' => "Shop $name at Leathers.pk. Premium quality, handcrafted in Pakistan. Free shipping on orders over Rs. 5000.",
                ]);
            }
        }
    }
}
