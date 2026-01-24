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
        'sale_starts_at',
        'sale_ends_at',
        'image',
        'images',
        'stock',
        'featured',
        'is_active',
        'meta_title',
        'meta_description',
        'sale_id',
        'daraz_url',
        'size_guide_image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
        'featured' => 'boolean',
        'is_active' => 'boolean',
        'sale_starts_at' => 'datetime',
        'sale_ends_at' => 'datetime',
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

        // Handle if images is a string (shouldn't happen but defensive coding)
        $images = $this->images;
        if (is_string($images)) {
            // Try to decode as JSON first
            $decoded = json_decode($images, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $images = $decoded;
            } else {
                // If not JSON, treat as single image
                $images = [$images];
            }
        }

        if (!is_array($images)) {
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
        }, $images);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
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
        // If sale_price is set, check validity dates
        if ($this->sale_price && $this->sale_price > 0) {
            $now = now();

            // Check start date (if set)
            if ($this->sale_starts_at && $now->lt($this->sale_starts_at)) {
                return $this->price;
            }

            // Check end date (if set)
            if ($this->sale_ends_at && $now->gt($this->sale_ends_at)) {
                return $this->price;
            }

            return $this->sale_price;
        }

        return $this->price;
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

        $effective = $this->effective_price;
        return 'Rs. ' . number_format($effective);
    }
}
