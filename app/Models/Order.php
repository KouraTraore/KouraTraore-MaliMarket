<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'numero', 'montant_total', 'statut',
        'mode_paiement', 'statut_paiement', 'nom_livraison',
        'telephone_livraison', 'adresse_livraison',
        'ville_livraison', 'notes'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Générer numéro automatiquement
    public static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->numero = 'MM-' . date('Ymd') . '-' . strtoupper(uniqid());
        });
    }

    // Statut en français
    public function statutLabel(): string
    {
        return match($this->statut) {
            'en_attente'   => 'En attente',
            'confirmee'    => 'Confirmée',
            'en_livraison' => 'En livraison',
            'livree'       => 'Livrée',
            'annulee'      => 'Annulée',
            default        => $this->statut,
        };
    }

    // Couleur badge statut
    public function statutColor(): string
    {
        return match($this->statut) {
            'en_attente'   => 'warning',
            'confirmee'    => 'info',
            'en_livraison' => 'primary',
            'livree'       => 'success',
            'annulee'      => 'danger',
            default        => 'secondary',
        };
    }
}