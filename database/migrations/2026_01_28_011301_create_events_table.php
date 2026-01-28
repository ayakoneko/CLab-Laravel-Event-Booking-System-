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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();

            $table->dateTime('starts_at'); // future date only
            $table->dateTime('ends_at')->nullable(); //must be equal or after starts_at

            $table->boolean('is_online')->default(0);
            $table->string('location', 255);
            $table->string('online_url')->nullable();

            $table->unsignedSmallInteger('capacity');    //min 1, max 1000
            $table->unsignedInteger('price_cents')->default(0);
            $table->char('currency', 3)->default('AUD');

            $table->string('image_path', 255)->nullable();
            $table->timestamps();

            $table->foreignId('organiser_id')->constrained('users')->cascadeOnDelete();

            $table->index('starts_at');
            $table->index(['organiser_id', 'starts_at']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
