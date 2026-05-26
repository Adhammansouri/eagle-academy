<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_subscription_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->string('type', 20);
            $table->decimal('amount', 10, 2)->default(0);
            $table->date('subscription_date');
            $table->date('expiration_date');
            $table->date('previous_subscription_date')->nullable();
            $table->date('previous_expiration_date')->nullable();
            $table->timestamps();

            $table->index(['player_id', 'created_at']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_subscription_histories');
    }
};
