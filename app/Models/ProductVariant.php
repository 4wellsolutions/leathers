<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'product_color_id',
        'name',
        'sku',
        'price',
        'sale_price',
        'stock',
        'size',
        'image', // Keeping for backward compatibility if needed, or remove if unused
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getEffectivePriceAttribute()
    {
        // Strict adherence to user request:
        // "if product has active sale_price then this should be apply everywhere"

        // 1. Check Global Product Sale
        if ($this->product && $this->product->has_active_sale) {
            return $this->product->sale_price;
        }

        // 2. Fallback to Variant Sale Price (if active/set)
        // Variants generally don't have separate sale dates in this system, so check > 0
        if ($this->sale_price && $this->sale_price > 0) {
            return $this->sale_price;
        }

        // 3. Fallback to Variant Regular Price
        if ($this->price) {
            return $this->price;
        }

        // 4. Fallback to Product Regular Price
        return $this->product->price;
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }
}
