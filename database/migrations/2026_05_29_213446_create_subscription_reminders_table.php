<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->date('expiration_date');
            $table->unsignedSmallInteger('days_before')->default(7);
            $table->string('status')->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('channel')->default('whatsapp');
            $table->text('message')->nullable();
            $table->timestamps();

            $table->unique(['player_id', 'expiration_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_reminders');
    }
};
