<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        foreach ($products as $product) {
            // Add 3-7 reviews per product
            $reviewCount = rand(3, 7);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $hasImages = rand(0, 100) < 40; // 40% chance of having images
                
                Review::create([
                    'user_id' => $users->random()->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5), // Mostly positive reviews
                    'comment' => $this->getRandomComment(),
                    'is_approved' => true,
                    'image1' => $hasImages && rand(0, 1) ? $this->getRandomReviewImage() : null,
                    'image2' => $hasImages && rand(0, 1) ? $this->getRandomReviewImage() : null,
                ]);
            }
            
            // Add some details content
            $product->update([
                'details' => "<h3>Premium Quality Material</h3>
<p>Crafted from 100% genuine full-grain leather, this product is designed to age beautifully, developing a unique patina over time. The hardware is made from solid brass with a high-quality finish to ensure durability and resistance to tarnish.</p>

<h3>Dimensions & Specifications</h3>
<ul>
    <li><strong>Material:</strong> Full-grain cowhide leather</li>
    <li><strong>Hardware:</strong> Solid brass buckles and rivets</li>
    <li><strong>Stitching:</strong> Heavy-duty nylon thread for longevity</li>
    <li><strong>Origin:</strong> Handcrafted in Pakistan by skilled artisans</li>
</ul>

<h3>Care Instructions</h3>
<p>To maintain the beauty of your leather product, avoid prolonged exposure to direct sunlight and moisture. Clean with a soft, dry cloth. For deeper conditioning, use a high-quality leather conditioner every 6-12 months.</p>"
            ]);
        }
    }

    private function getRandomComment()
    {
        $comments = [
            "Absolutely love this! The quality is unmatched.",
            "Great product, fast shipping. Will buy again.",
            "The leather feels so premium. Highly recommended!",
            "Exceeded my expectations. Beautiful craftsmanship.",
            "Good value for money. Looks exactly like the pictures.",
            "Perfect gift for my husband. He loves it!",
            "Very durable and stylish. I use it every day.",
            "Customer service was excellent. The product is amazing.",
            "Exactly what I was looking for. Top quality!",
            "The stitching is perfect. Very well made.",
            "Impressed with the attention to detail.",
            "Worth every penny. Fantastic purchase!"
        ];

        return $comments[array_rand($comments)];
    }

    private function getRandomReviewImage()
    {
        $images = [
            '/images/reviews/review-1.jpg',
            '/images/reviews/review-2.jpg',
            '/images/reviews/review-3.jpg',
            '/images/reviews/review-4.jpg',
            '/images/reviews/review-5.jpg',
        ];

        return $images[array_rand($images)];
    }
}
