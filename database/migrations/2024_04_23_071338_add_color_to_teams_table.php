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
        // Ajout de la colonne color à la table teams
        Schema::table('teams', function (Blueprint $table) {
            $table->string('color')->nullable(); // La colonne peut être nulle
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la colonne color de la table teams lors d'un rollback
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
