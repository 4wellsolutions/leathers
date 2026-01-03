<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductVariant;

use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        
        ProductVariant::truncate();
        ProductColor::truncate();
        Product::truncate();
        
        Schema::enableForeignKeyConstraints();

        $this->createBelts();
        $this->createWallets();
        $this->createWatches();
        $this->createBags();
    }

    private function createBelts()
    {
        // Belt 1: Classic Leather Belt
        $product = Product::create([
            'category_id' => 1,
            'name' => 'Classic Leather Belt',
            'slug' => 'classic-leather-belt',
            'description' => 'Handcrafted from premium Italian leather, this classic belt features a timeless design perfect for both formal and casual wear.',
            'details' => '<p>Features: Genuine leather, Brass buckle, 3.5cm width</p>',
            'image' => 'https://placehold.co/800x800/8B4513/FFFFFF/png?text=Classic+Belt',
            'featured' => true,
            'is_active' => true,
            'price' => 2500,
            'sale_price' => 1999,
        ]);
        
        $blackColor = ProductColor::create(['product_id' => $product->id, 'name' => 'Black', 'color_code' => '#000000']);
        $brownColor = ProductColor::create(['product_id' => $product->id, 'name' => 'Brown', 'color_code' => '#8B4513']);
        
        foreach (['32', '34', '36', '38', '40', '42'] as $size) {
            ProductVariant::create([
                'product_id' => $product->id,
                'product_color_id' => $blackColor->id,
                'name' => "Black - $size",
                'size' => $size,
                'price' => 2500,
                'sale_price' => 1999,
                'stock' => rand(5, 15),
                'sku' => "BELT-BLK-$size",
            ]);
            
            ProductVariant::create([
                'product_id' => $product->id,
                'product_color_id' => $brownColor->id,
                'name' => "Brown - $size",
                'size' => $size,
                'price' => 2500,
                'stock' => rand(5, 15),
                'sku' => "BELT-BRN-$size",
            ]);
        }

        // Belt 2: Premium Reversible Belt
        $product2 = Product::create([
            'category_id' => 1,
            'name' => 'Premium Reversible Belt',
            'slug' => 'premium-reversible-belt',
            'description' => 'Versatile reversible belt with black and brown sides. Perfect for travelers and professionals.',
            'details' => '<p>Reversible design, Automatic buckle, Full grain leather</p>',
            'image' => 'https://placehold.co/800x800/654321/FFFFFF/png?text=Reversible+Belt',
            'featured' => false,
            'is_active' => true,
            'price' => 3500,
            'sale_price' => 2999,
        ]);
        
        $reversibleColor = ProductColor::create(['product_id' => $product2->id, 'name' => 'Black/Brown', 'color_code' => '#000000']);
        
        foreach (['34', '36', '38', '40'] as $size) {
            ProductVariant::create([
                'product_id' => $product2->id,
                'product_color_id' => $reversibleColor->id,
                'name' => "Black/Brown - $size",
                'size' => $size,
                'price' => 3500,
                'sale_price' => 2999,
                'stock' => rand(3, 10),
                'sku' => "BELT-REV-$size",
            ]);
        }

        // Belt 3: Formal Leather Belt
        $product3 = Product::create([
            'category_id' => 1,
            'name' => 'Formal Leather Belt',
            'slug' => 'formal-leather-belt',
            'description' => 'Sleek and sophisticated belt designed for formal occasions and business settings.',
            'image' => 'https://placehold.co/800x800/2F4F4F/FFFFFF/png?text=Formal+Belt',
            'featured' => false,
            'is_active' => true,
            'price' => 2200,
            // No sale price to test mixed display
        ]);
        
        $formalBlack = ProductColor::create(['product_id' => $product3->id, 'name' => 'Black', 'color_code' => '#000000']);
        
        foreach (['32', '34', '36', '38', '40'] as $size) {
            ProductVariant::create([
                'product_id' => $product3->id,
                'product_color_id' => $formalBlack->id,
                'name' => "Black - $size",
                'size' => $size,
                'price' => 2200,
                'stock' => rand(5, 12),
                'sku' => "BELT-FML-$size",
            ]);
        }
    }

    private function createWallets()
    {
        // Wallet 1: Bifold Leather Wallet
        $product = Product::create([
            'category_id' => 2,
            'name' => 'Bifold Leather Wallet',
            'slug' => 'bifold-leather-wallet',
            'description' => 'Classic bifold wallet with 6 card slots, 2 bill compartments, and RFID protection.',
            'details' => '<p>RFID blocking, 6 card slots, Slim design, Genuine leather</p>',
            'image' => 'https://placehold.co/800x800/654321/FFFFFF/png?text=Bifold+Wallet',
            'featured' => true,
            'is_active' => true,
        ]);
        
        $walletBlack = ProductColor::create(['product_id' => $product->id, 'name' => 'Black', 'color_code' => '#000000']);
        $walletBrown = ProductColor::create(['product_id' => $product->id, 'name' => 'Brown', 'color_code' => '#8B4513']);
        
        foreach ([$walletBlack, $walletBrown] as $color) {
            ProductVariant::create([
                'product_id' => $product->id,
                'product_color_id' => $color->id,
                'name' => $color->name . ' - Standard',
                'size' => 'Standard',
                'price' => 1999,
                'sale_price' => 1499,
                'stock' => rand(10, 20),
                'sku' => "WALLET-BF-" . strtoupper(substr($color->name, 0, 3)),
            ]);
        }

        // Wallet 2: Minimalist Card Holder
        $product2 = Product::create([
            'category_id' => 2,
            'name' => 'Minimalist Card Holder',
            'slug' => 'minimalist-card-holder',
            'description' => 'Ultra-slim card holder perfect for minimalists. Holds 4-8 cards comfortably.',
            'details' => '<p>Slim design, Premium leather, RFID protection</p>',
            'image' => 'https://placehold.co/800x800/8B7355/FFFFFF/png?text=Card+Holder',
            'featured' => false,
            'is_active' => true,
        ]);
        
        $chBlack = ProductColor::create(['product_id' => $product2->id, 'name' => 'Black', 'color_code' => '#000000']);
        $chBrown = ProductColor::create(['product_id' => $product2->id, 'name' => 'Tan', 'color_code' => '#D2B48C']);
        
        foreach ([$chBlack, $chBrown] as $color) {
            ProductVariant::create([
                'product_id' => $product2->id,
                'product_color_id' => $color->id,
                'name' => $color->name . ' - Mini',
                'size' => 'Mini',
                'price' => 1299,
                'stock' => rand(15, 25),
                'sku' => "WALLET-CH-" . strtoupper(substr($color->name, 0, 3)),
            ]);
        }

        // Wallet 3: Long Wallet
        $product3 = Product::create([
            'category_id' => 2,
            'name' => 'Long Leather Wallet',
            'slug' => 'long-leather-wallet',
            'description' => 'Spacious long wallet with multiple compartments for cards, cash, and coins.',
            'image' => 'https://placehold.co/800x800/8B4513/FFFFFF/png?text=Long+Wallet',
            'featured' => false,
            'is_active' => true,
        ]);
        
        $longBlack = ProductColor::create(['product_id' => $product3->id, 'name' => 'Black', 'color_code' => '#000000']);
        
        ProductVariant::create([
            'product_id' => $product3->id,
            'product_color_id' => $longBlack->id,
            'name' => 'Black - Long',
            'size' => 'Long',
            'price' => 2499,
            'sale_price' => 1999,
            'stock' => rand(8, 15),
            'sku' => 'WALLET-LONG-BLK',
        ]);
    }

    private function createWatches()
    {
        // Watch 1: Classic Analog Watch
        $product = Product::create([
            'category_id' => 3,
            'name' => 'Classic Analog Watch',
            'slug' => 'classic-analog-watch',
            'description' => 'Timeless analog watch with genuine leather strap and stainless steel case.',
            'details' => '<p>Water resistant, Japanese movement, Leather strap</p>',
            'image' => 'https://placehold.co/800x800/2F4F4F/FFFFFF/png?text=Classic+Watch',
            'featured' => true,
            'is_active' => true,
        ]);
        
        $watchBlack = ProductColor::create(['product_id' => $product->id, 'name' => 'Black Strap', 'color_code' => '#000000']);
        $watchBrown = ProductColor::create(['product_id' => $product->id, 'name' => 'Brown Strap', 'color_code' => '#8B4513']);
        
        foreach ([$watchBlack, $watchBrown] as $color) {
            ProductVariant::create([
                'product_id' => $product->id,
                'product_color_id' => $color->id,
                'name' => $color->name . ' - 42mm',
                'size' => '42mm',
                'price' => 4999,
                'sale_price' => 3999,
                'stock' => rand(5, 12),
                'sku' => "WATCH-CLK-" . strtoupper(substr($color->name, 0, 3)),
            ]);
        }

        // Watch 2: Chronograph Watch
        $product2 = Product::create([
            'category_id' => 3,
            'name' => 'Chronograph Leather Watch',
            'slug' => 'chronograph-leather-watch',
            'description' => 'Multi-functional chronograph watch with premium leather strap.',
            'image' => 'https://placehold.co/800x800/696969/FFFFFF/png?text=Chronograph',
            'featured' => false,
            'is_active' => true,
        ]);
        
        $chronoBlack = ProductColor::create(['product_id' => $product2->id, 'name' => 'Black', 'color_code' => '#000000']);
        
        ProductVariant::create([
            'product_id' => $product2->id,
            'product_color_id' => $chronoBlack->id,
            'name' => 'Black - 44mm',
            'size' => '44mm',
            'price' => 6999,
            'stock' => rand(3, 8),
            'sku' => 'WATCH-CHR-BLK',
        ]);
    }

    private function createBags()
    {
        // Bag 1: Messenger Bag
        $product = Product::create([
            'category_id' => 4,
            'name' => 'Leather Messenger Bag',
            'slug' => 'leather-messenger-bag',
            'description' => 'Professional messenger bag with laptop compartment and multiple pockets.',
            'details' => '<p>Fits 15" laptop, Adjustable strap, Multiple compartments</p>',
            'image' => 'https://placehold.co/800x800/8B7355/FFFFFF/png?text=Messenger+Bag',
            'featured' => true,
            'is_active' => true,
        ]);
        
        $bagBrown = ProductColor::create(['product_id' => $product->id, 'name' => 'Brown', 'color_code' => '#8B4513']);
        $bagBlack = ProductColor::create(['product_id' => $product->id, 'name' => 'Black', 'color_code' => '#000000']);
        
        foreach ([$bagBrown, $bagBlack] as $color) {
            ProductVariant::create([
                'product_id' => $product->id,
                'product_color_id' => $color->id,
                'name' => $color->name . ' - Medium',
                'size' => 'Medium',
                'price' => 8999,
                'sale_price' => 7499,
                'stock' => rand(3, 8),
                'sku' => "BAG-MSG-" . strtoupper(substr($color->name, 0, 3)),
            ]);
        }

        // Bag 2: Backpack
        $product2 = Product::create([
            'category_id' => 4,
            'name' => 'Leather Backpack',
            'slug' => 'leather-backpack',
            'description' => 'Spacious leather backpack perfect for daily commute and travel.',
            'image' => 'https://placehold.co/800x800/654321/FFFFFF/png?text=Backpack',
            'featured' => false,
            'is_active' => true,
        ]);
        
        $bpBrown = ProductColor::create(['product_id' => $product2->id, 'name' => 'Brown', 'color_code' => '#8B4513']);
        
        ProductVariant::create([
            'product_id' => $product2->id,
            'product_color_id' => $bpBrown->id,
            'name' => 'Brown - Large',
            'size' => 'Large',
            'price' => 9999,
            'sale_price' => 8499,
            'stock' => rand(5, 10),
            'sku' => 'BAG-BP-BRN',
        ]);
    }
}
