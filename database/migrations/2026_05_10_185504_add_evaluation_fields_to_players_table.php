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
        Schema::table('players', function (Blueprint $table) {
            $table->tinyInteger('speed_score')->nullable();
            $table->tinyInteger('fitness_score')->nullable();
            $table->tinyInteger('tactical_score')->nullable();
            $table->text('coach_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn(['speed_score', 'fitness_score', 'tactical_score', 'coach_notes']);
        });
    }
};
