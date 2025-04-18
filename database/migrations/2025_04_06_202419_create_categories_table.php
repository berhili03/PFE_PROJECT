<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->string('name')->primary();  // Déclare `name` comme clé primaire
            $table->timestamps();  // Ajoute created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');  // Supprime la table categories
    }
};
