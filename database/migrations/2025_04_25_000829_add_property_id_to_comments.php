
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('commentaires', function (Blueprint $table) {
            $table->foreignId('property_id')
                  ->constrained('properties')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('commentaires', function (Blueprint $table) {
            $table->dropForeign(['property_id']); // Supprimer la clé étrangère
            $table->dropColumn('property_id');    // Supprimer la colonne ensuite
        });
    }
};
