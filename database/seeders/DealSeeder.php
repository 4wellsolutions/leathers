<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deal;

class DealSeeder extends Seeder
{
    public function run(): void
    {
        Deal::create([
            'name' => 'Flash Sale',
            'slug' => 'flash-sale',
            'description' => 'Limited time offer - 20% off on selected items',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'starts_at' => now(),
            'ends_at' => now()->addDays(7),
            'is_active' => true,
        ]);

        Deal::create([
            'name' => 'Clearance Sale',
            'slug' => 'clearance',
            'description' => 'End of season clearance - Up to 30% off',
            'discount_type' => 'percentage',
            'discount_value' => 30,
            'starts_at' => now()->subDays(5),
            'ends_at' => now()->addDays(15),
            'is_active' => true,
        ]);

        Deal::create([
            'name' => 'New Arrivals',
            'slug' => 'new-arrivals',
            'description' => 'Special discount on new arrivals',
            'discount_type' => 'fixed',
            'discount_value' => 500,
            'starts_at' => now()->subDays(30),
            'ends_at' => now()->subDays(5),
            'is_active' => false,
        ]);
    }
}
