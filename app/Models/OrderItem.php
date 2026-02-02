<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'product_name',
        'price',
        'quantity',
        'subtotal'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->variant && $this->variant->color && $this->variant->color->image_url) {
            return $this->variant->color->image_url;
        }

        return $this->product ? $this->product->image_url : asset('images/placeholder.jpg');
    }
}
