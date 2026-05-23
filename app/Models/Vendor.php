<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'user_id', 'nom_boutique', 'slug', 'description',
        'logo', 'telephone', 'adresse', 'ville',
        'statut', 'commission'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Générer le slug automatiquement
    public static function boot()
    {
        parent::boot();
        static::creating(function ($vendor) {
            $vendor->slug = \Str::slug($vendor->nom_boutique);
        });
    }
}