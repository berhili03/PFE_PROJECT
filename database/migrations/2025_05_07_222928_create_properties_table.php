<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('nomProduit');
            $table->longText('description');
            $table->string('category_name');
            $table->float('prix');
            $table->string('marque');
            $table->binary('image');
            $table->timestamps();

            $table->foreign('category_name')
                ->references('name')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};