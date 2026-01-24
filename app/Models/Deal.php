<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(DealItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'deal_items')->withPivot('quantity');
    }

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'deal_items', 'deal_id', 'product_variant_id')
            ->withPivot('quantity');
    }

    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        return true;
    }
}
