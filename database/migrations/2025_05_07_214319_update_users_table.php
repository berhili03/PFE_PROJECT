<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer le champ dateNaissance s'il existe
            if (Schema::hasColumn('users', 'dateNaissance')) {
                $table->dropColumn('dateNaissance');
            }

            // Ajouter les nouveaux champs s'ils n'existent pas déjà
            if (!Schema::hasColumn('users', 'tel')) {
                $table->string('tel')->after('email');
            }
            
            if (!Schema::hasColumn('users', 'sexe')) {
                $table->enum('sexe', ['Femme', 'Homme'])->after('tel');
            }
            
            if (!Schema::hasColumn('users', 'adresse')) {
                $table->text('adresse')->after('sexe');
            }
            
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'Consommateur', 'Commercant'])
                     ->default('Consommateur')
                     ->after('adresse');
            }
            
            if (!Schema::hasColumn('users', 'store_name')) {
                $table->string('store_name')->nullable()->after('role');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Ne pas recréer dateNaissance dans le down()
            
            $table->dropColumn([
                'tel',
                'sexe',
                'adresse', 
                'role',
                'store_name'
            ]);
        });
    }
};