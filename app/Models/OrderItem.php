<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'vendor_id',
        'quantite', 'prix_unitaire', 'sous_total'
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'sous_total'    => 'decimal:2',
    ];

    // Relations
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}