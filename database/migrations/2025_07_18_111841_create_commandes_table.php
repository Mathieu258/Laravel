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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stand_id');
            $table->unsignedBigInteger('user_id');
            $table->text('details_commande'); // JSON ou texte
            $table->enum('statut', ['en_attente', 'confirmee', 'en_preparation', 'livree', 'annulee'])->default('en_attente');
            $table->decimal('total_prix', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('date_commande')->useCurrent();
            $table->timestamps();

            $table->foreign('stand_id')->references('id')->on('stands')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
