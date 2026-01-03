<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingRule;

class ShippingRuleSeeder extends Seeder
{
    public function run(): void
    {
        ShippingRule::create([
            'name' => 'Standard Shipping',
            'min_amount' => 0,
            'max_amount' => 4999,
            'cost' => 200,
            'is_free' => false,
            'is_active' => true,
            'priority' => 1,
        ]);

        ShippingRule::create([
            'name' => 'Free Shipping',
            'min_amount' => 5000,
            'max_amount' => null,
            'cost' => 0,
            'is_free' => true,
            'is_active' => true,
            'priority' => 0,
        ]);
    }
}
