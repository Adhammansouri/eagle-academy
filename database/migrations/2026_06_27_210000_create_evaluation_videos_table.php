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
        Schema::create('evaluation_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_evaluation_id')->constrained('player_evaluations')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->string('video_path');
            $table->string('original_name');
            $table->unsignedInteger('file_size')->default(0);
            $table->unsignedSmallInteger('duration_seconds')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_videos');
    }
};
