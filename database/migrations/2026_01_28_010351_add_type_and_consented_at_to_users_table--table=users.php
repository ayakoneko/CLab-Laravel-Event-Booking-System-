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
        Schema::table('users', function(Blueprint $table){
            $table->string('type')->default('attendee')->after('password');
            $table->dateTime('consented_at')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->dropColumn(['type', 'consented_at']);
        });
    }
};
