<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
    ];

    /**
     * Get all blogs in this category
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Get published blogs count
     */
    public function publishedBlogsCount()
    {
        return $this->blogs()->where('status', 'published')->count();
    }
}
