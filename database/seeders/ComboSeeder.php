<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Combo;
use App\Models\Product;

class ComboSeeder extends Seeder
{
    public function run(): void
    {
        $combos = [
            [
                'name' => 'The Gentleman Set',
                'slug' => 'the-gentleman-set',
                'description' => 'A classic combination of a leather belt and a matching wallet.',
                'price' => 7500.00,
                'image' => '/images/products/belt-brown.png', // Placeholder
                'is_active' => true,
                'items' => [
                    ['category_id' => 1, 'count' => 1], // 1 Belt
                    ['category_id' => 2, 'count' => 1], // 1 Wallet
                ]
            ],
            [
                'name' => 'Executive Bundle',
                'slug' => 'executive-bundle',
                'description' => 'Everything you need for the office: Belt, Wallet, and Watch.',
                'price' => 18000.00,
                'image' => '/images/products/watch-brown.png', // Placeholder
                'is_active' => true,
                'items' => [
                    ['category_id' => 1, 'count' => 1],
                    ['category_id' => 2, 'count' => 1],
                    ['category_id' => 3, 'count' => 1],
                ]
            ],
            [
                'name' => 'Gift Set for Him',
                'slug' => 'gift-set-for-him',
                'description' => 'Perfect gift containing two premium leather belts.',
                'price' => 9000.00,
                'image' => '/images/products/belt-black.png', // Placeholder
                'is_active' => true,
                'items' => [
                    ['category_id' => 1, 'count' => 2],
                ]
            ],
        ];

        foreach ($combos as $comboData) {
            $items = $comboData['items'];
            unset($comboData['items']);

            $combo = Combo::firstOrCreate(
                ['slug' => $comboData['slug']],
                $comboData
            );

            if ($combo->products()->count() == 0) {
                foreach ($items as $item) {
                    // Find random products from the specified category
                    $products = Product::where('category_id', $item['category_id'])
                        ->inRandomOrder()
                        ->take($item['count'])
                        ->get();

                    foreach ($products as $product) {
                        $combo->products()->attach($product->id);
                    }
                }
            }
        }
    }
}
