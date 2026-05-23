<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('numero')->unique();
            $table->decimal('montant_total', 10, 2);
            $table->enum('statut', [
                'en_attente',
                'confirmee',
                'en_livraison',
                'livree',
                'annulee'
            ])->default('en_attente');
            $table->enum('mode_paiement', [
                'livraison',
                'orange_money',
                'moov_money'
            ])->default('livraison');
            $table->enum('statut_paiement', [
                'non_paye',
                'paye'
            ])->default('non_paye');
            $table->string('nom_livraison');
            $table->string('telephone_livraison');
            $table->string('adresse_livraison');
            $table->string('ville_livraison')->default('Bamako');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};