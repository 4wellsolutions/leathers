<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'details',
        'price',
        'sale_price',
        'image',
        'images',
        'stock',
        'featured',
        'is_active',
        'meta_title',
        'meta_description',
        'deal_id',
        'daraz_url',
        'size_guide_image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'images' => 'array',
        'stock' => 'integer',
        'featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/placeholder.jpg');
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // Remove 'storage/' prefix if it exists (for old database entries)
        $cleanPath = str_starts_with($this->image, 'storage/')
            ? substr($this->image, 8)
            : $this->image;

        // Images are now stored directly in public folder
        return asset($cleanPath);
    }

    public function getImagesUrlsAttribute()
    {
        if (!$this->images) {
            return [];
        }

        return array_map(function ($image) {
            if (str_starts_with($image, 'http')) {
                return $image;
            }

            // Remove 'storage/' prefix if it exists (for old database entries)
            $cleanPath = str_starts_with($image, 'storage/')
                ? substr($image, 8)
                : $image;

            // Images are now stored directly in public folder
            return asset($cleanPath);
        }, $this->images);
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getEffectivePriceAttribute()
    {
        $price = $this->sale_price ?? $this->price;

        if ($this->deal && $this->deal->isValid()) {
            if ($this->deal->discount_type === 'percentage') {
                $discount = $price * ($this->deal->discount_value / 100);
                return max(0, $price - $discount);
            } elseif ($this->deal->discount_type === 'fixed') {
                return max(0, $price - $this->deal->discount_value);
            }
        }

        return $price;
    }

    public function getPriceRangeAttribute()
    {
        if ($this->variants()->count() > 0) {
            $min = $this->variants()->min('price') ?? $this->price;
            $max = $this->variants()->max('price') ?? $this->price;

            if ($min == $max) {
                return 'Rs. ' . number_format($min);
            }

            return 'Rs. ' . number_format($min) . ' - Rs. ' . number_format($max);
        }

        return 'Rs. ' . number_format($this->sale_price ?? $this->price);
    }
}
