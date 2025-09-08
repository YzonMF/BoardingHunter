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
    $table->bigIncrements('AmenityID');
    $table->unsignedBigInteger('AccommodationID');
    $table->string('AmenityName', 100);
    $table->string('Description');

    $table->foreign('AccommodationID')->references('AccomodationID')->on('accommodations');
});
+
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
