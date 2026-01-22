<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = [
        'from_url',
        'to_url',
        'old_url',
        'new_url',
        'status_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the column name for the "from" URL based on DB schema.
     */
    public static function getFromColumn()
    {
        return \Illuminate\Support\Facades\Cache::remember('redirect_schema_from_col', 3600, function () {
            return \Illuminate\Support\Facades\Schema::hasColumn('redirects', 'from_url') ? 'from_url' : 'old_url';
        });
    }

    /**
     * Get the column name for the "to" URL based on DB schema.
     */
    public static function getToColumn()
    {
        return \Illuminate\Support\Facades\Cache::remember('redirect_schema_to_col', 3600, function () {
            return \Illuminate\Support\Facades\Schema::hasColumn('redirects', 'to_url') ? 'to_url' : 'new_url';
        });
    }

    // Accessors to Unify Interface
    public function getFromUrlAttribute($value)
    {
        return $value ?? $this->attributes['old_url'] ?? null;
    }

    public function getToUrlAttribute($value)
    {
        return $value ?? $this->attributes['new_url'] ?? null;
    }

    // Mutators to ensure data is saved to the correct column
    public function setFromUrlAttribute($value)
    {
        $col = self::getFromColumn();
        $this->attributes[$col] = $value;
    }

    public function setToUrlAttribute($value)
    {
        $col = self::getToColumn();
        $this->attributes[$col] = $value;
    }

    /**
     * Clear the cache for this redirect.
     */
    public function clearCache()
    {
        $fromCol = self::getFromColumn();
        $path = trim($this->{$fromCol}, '/');
        \Illuminate\Support\Facades\Cache::forget("redirect_{$path}");
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saved(function ($redirect) {
            $redirect->clearCache();
        });

        static::deleted(function ($redirect) {
            $redirect->clearCache();
        });
    }
}
