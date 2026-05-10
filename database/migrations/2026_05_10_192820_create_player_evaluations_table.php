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
        Schema::create('player_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->date('evaluation_date');
            $table->tinyInteger('tech_score')->default(1);
            $table->tinyInteger('speed_score')->default(1);
            $table->tinyInteger('defense_score')->default(1);
            $table->tinyInteger('fitness_score')->default(1);
            $table->tinyInteger('discipline_score')->default(1);
            $table->text('coach_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_evaluations');
    }
};
