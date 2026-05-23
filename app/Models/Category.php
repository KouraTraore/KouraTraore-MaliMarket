<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'nom', 'slug', 'description', 'image', 'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relation
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Générer le slug automatiquement
    public static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = \Str::slug($category->nom);
        });
    }
}