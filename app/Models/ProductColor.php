<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'color_code',
        'image',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
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
            return asset($image);
        }, $this->images);
    }

    public function getRelativeImagePathAttribute()
    {
        $imagePath = null;

        // PRIORITIZE 'images' array as per user request
        if ($this->images && count($this->images) > 0) {
            $imagePath = $this->images[0];
        }

        // Fallback to 'image' field if array is empty
        if (!$imagePath) {
            $imagePath = $this->image;
        }

        if (!$imagePath) {
            return null;
        }

        if (str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }

        // Clean path (remove storage prefix)
        $cleanPath = str_starts_with($imagePath, 'storage/')
            ? substr($imagePath, 8)
            : $imagePath;

        // Check if file exists roughly where we expect it
        // If it starts with products/colors, check if it exists there, if not check product-colors
        if (str_starts_with($cleanPath, 'products/colors/')) {
            if (file_exists(public_path($cleanPath))) {
                return $cleanPath;
            }
            // Try swapping to product-colors
            $altPath = str_replace('products/colors/', 'product-colors/', $cleanPath);
            if (file_exists(public_path($altPath))) {
                return $altPath;
            }
        }

        // Use consistent formatting (root-relative) for browser
        return str_starts_with($cleanPath, '/') ? $cleanPath : '/' . $cleanPath;
    }

    public function getImageUrlAttribute()
    {
        $relativePath = $this->relative_image_path;

        if (!$relativePath) {
            return asset('images/placeholder.jpg');
        }

        if (str_starts_with($relativePath, 'http')) {
            return $relativePath;
        }

        return asset(ltrim($relativePath, '/'));
    }
}
