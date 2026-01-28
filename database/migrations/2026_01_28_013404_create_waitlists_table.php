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
        Schema::create('waitlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unique(['event_id', 'user_id']);

            $table->unsignedInteger('position');
            $table->dateTime('notified_at')->nullable();
            $table->dateTime('offer_expires_at')->nullable();
            $table->boolean('offer_accepted')->default(false);
            $table->timestamps();

            $table->index(['event_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlists');
    }
};
