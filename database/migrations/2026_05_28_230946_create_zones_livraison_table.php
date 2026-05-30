<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zones_livraison', function (Blueprint $table) {
            $table->id();
            $table->string('quartier');
            $table->string('ville')->default('Bamako');
            $table->integer('frais');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones_livraison');
    }
};