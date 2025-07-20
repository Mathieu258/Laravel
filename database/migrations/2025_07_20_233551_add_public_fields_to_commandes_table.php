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
        Schema::table('commandes', function (Blueprint $table) {
            // Champs pour les commandes publiques (clients non connectés)
            $table->string('nom_client')->nullable()->after('user_id');
            $table->string('email_client')->nullable()->after('nom_client');
            $table->string('telephone_client')->nullable()->after('email_client');
            $table->text('adresse_livraison')->nullable()->after('telephone_client');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn([
                'nom_client',
                'email_client',
                'telephone_client',
                'adresse_livraison'
            ]);
        });
    }
};
