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
        Schema::create('seekers', function (Blueprint $table) {
        $table->unsignedBigInteger('UserID')->primary();
        $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
        $table->string('Preferences', 100)->nullable();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_seekers');
    }
};
