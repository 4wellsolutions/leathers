<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    protected $fillable = [
        'name',
        'min_amount',
        'max_amount',
        'cost',
        'is_free',
        'is_active',
        'priority',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'cost' => 'decimal:2',
        'is_free' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get applicable shipping cost for given cart total
     */
    public static function getShippingCost($cartTotal)
    {
        $rule = static::where('is_active', true)
            ->where(function ($query) use ($cartTotal) {
                $query->where(function ($q) use ($cartTotal) {
                    // Min amount check
                    $q->whereNull('min_amount')
                      ->orWhere('min_amount', '<=', $cartTotal);
                })
                ->where(function ($q) use ($cartTotal) {
                    // Max amount check
                    $q->whereNull('max_amount')
                      ->orWhere('max_amount', '>=', $cartTotal);
                });
            })
            ->orderBy('priority', 'asc')
            ->first();

        if ($rule) {
            return $rule->is_free ? 0 : $rule->cost;
        }

        // Default shipping if no rule matches
        return 200; // Default Rs. 200
    }

    /**
     * Scope for active rules
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
