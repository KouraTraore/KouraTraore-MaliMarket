<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'vendor_id', 'category_id', 'nom', 'slug',
        'description', 'prix', 'prix_promo', 'stock',
        'image', 'statut', 'vues'
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'prix_promo' => 'decimal:2',
    ];

    // Relations
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Prix final (promo ou normal)
    public function prixFinal()
    {
        return $this->prix_promo ?? $this->prix;
    }

    // Est en promo ?
    public function enPromo(): bool
    {
        return !is_null($this->prix_promo) && $this->prix_promo < $this->prix;
    }

    // En stock ?
    public function enStock(): bool
    {
        return $this->stock > 0;
    }

    // Générer le slug automatiquement
    public static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = \Str::slug($product->nom) . '-' . uniqid();
        });
    }
}