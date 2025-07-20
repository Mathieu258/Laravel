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
            $table->unsignedBigInteger('user_id')->after('stand_id');
            $table->enum('statut', ['en_attente', 'confirmee', 'en_preparation', 'livree', 'annulee'])->default('en_attente')->after('details_commande');
            $table->decimal('total_prix', 8, 2)->default(0)->after('statut');
            $table->text('notes')->nullable()->after('total_prix');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'statut', 'total_prix', 'notes']);
        });
    }
};
