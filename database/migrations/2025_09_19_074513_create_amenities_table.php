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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id('AmenityID'); // Use id() instead of unsignedBigInteger
            $table->unsignedBigInteger('AccommodationID');
            $table->string('AmenityName', 100);
            $table->string('Description', 500);

            // Fix foreign key syntax
            $table->foreign('AccommodationID')
                ->references('AccommodationID')
                ->on('accommodations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
