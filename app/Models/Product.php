<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'category',
        'weight',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'price'       => 'decimal:2',
    ];

    // Scope pour les produits actifs
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope pour les produits en vedette, triés par sort_order
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->orderBy('sort_order');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessor pour l'URL de l'image
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (file_exists(public_path('assets/images/' . $this->image))) {
                return asset('assets/images/' . $this->image);
            }
            if (file_exists(public_path('storage/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
        }
        return asset('assets/images/products/premium1kg.jpg');
    }
}
