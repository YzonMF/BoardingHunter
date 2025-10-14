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
         Schema::create('accommodation', function (Blueprint $table) {
            $table->bigIncrement('AccommodationID');
            $table->unsignedBigInteger('OwnerID');
            $table->string('Name', 100);
            $table->enum('Type',['Boarding','Transient','Hotel']);
            $table->string('Description');
            $table->string('Location');
            $table->decimal('PricePerNight', 10, 2);
            $table->decimal('PricePerMonth', 10, 2);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
