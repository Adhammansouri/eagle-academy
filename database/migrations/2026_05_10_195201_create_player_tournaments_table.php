<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_tournaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->string('tournament_name');
            $table->date('tournament_date');
            $table->string('location')->nullable();
            $table->enum('medal', ['gold', 'silver', 'bronze', 'participant'])->default('participant');
            $table->string('weight_class')->nullable();
            $table->integer('position')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_tournaments');
    }
};
