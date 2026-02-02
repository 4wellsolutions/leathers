<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount_amount',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($total)
    {
        // Check minimum order amount
        if ($this->min_order_amount && $total < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = ($total * $this->value) / 100;
            if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
                return $this->max_discount_amount;
            }
            return $discount;
        }

        return min($this->value, $total); // Ensure discount doesn't exceed total
    }
}
