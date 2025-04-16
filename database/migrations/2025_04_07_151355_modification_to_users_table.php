
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dateNaissance');
            $table->text('adresse');
            $table->enum('sexe', ['Femme', 'Homme']);
            $table->enum('role',['admin','Consommateur','Commercant']);
            $table->string('tel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dateNaissance', 'adresse', 'sexe', 'role', 'tel']);
        });
    }
};
