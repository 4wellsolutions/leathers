<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        BlogCategory::create(['name' => 'Style Tips', 'slug' => 'style-tips', 'description' => 'Fashion and styling advice']);
        BlogCategory::create(['name' => 'Leather Care', 'slug' => 'leather-care', 'description' => 'How to maintain your leather products']);
        BlogCategory::create(['name' => 'Product Reviews', 'slug' => 'reviews', 'description' => 'In-depth product reviews']);
        BlogCategory::create(['name' => 'News', 'slug' => 'news', 'description' => 'Latest updates and announcements']);
    }
}
