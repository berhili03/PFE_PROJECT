<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();  // Identifiant unique pour chaque propriété
            $table->string('nomProduit');  // Nom du produit
            $table->longText('description');  // Description du produit
            $table->string('category_name');  // Référence à `name` dans `categories`
            $table->float('prix');  // Prix du produit
            $table->string('marque');  // Marque du produit
            $table->binary('image');  // Image binaire du produit
            $table->timestamps();  // Ajoute created_at et updated_at

            // Ajouter une contrainte de clé étrangère
            $table->foreign('category_name')
                  ->references('name')
                  ->on('categories')
                  ->onDelete('cascade');  // Si la catégorie est supprimée, supprimer les propriétés associées
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');  // Supprimer la table properties
    }
};
