<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suivis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consommateur_id'); // ID du consommateur qui suit
            $table->unsignedBigInteger('commercant_id'); // ID du commerçant suivi
            $table->timestamps();
            
            // Contraintes de clé étrangère
            $table->foreign('consommateur_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('commercant_id')->references('id')->on('users')->onDelete('cascade');
            
            // Garantir qu'un consommateur ne peut suivre un commerçant qu'une seule fois
            $table->unique(['consommateur_id', 'commercant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suivis');
    }
};