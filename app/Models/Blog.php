<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'blog_category_id',
        'user_id',
        'featured_image',
        'gallery_images',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'tags',
        'views',
        'featured',
        'allow_comments',
        'include_in_sitemap',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'tags' => 'array',
        'published_at' => 'datetime',
        'featured' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    /**
     * Get the category of the blog
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Get the author of the blog
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope to get only published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope to get featured blogs
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Get excerpt or generate from content
     */
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        return Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Check if blog is published
     */
    public function isPublished()
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at <= now();
    }
}
