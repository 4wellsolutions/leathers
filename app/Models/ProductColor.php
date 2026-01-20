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

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
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
}
