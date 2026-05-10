<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_fights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->date('fight_date');
            $table->string('opponent_name');
            $table->string('opponent_club')->nullable();
            $table->enum('result', ['win', 'loss', 'draw']);
            $table->enum('result_method', ['points', 'ko', 'tko', 'rsc', 'walkover', 'dq'])->nullable();
            $table->integer('rounds')->nullable();
            $table->string('weight_class')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_fights');
    }
};
