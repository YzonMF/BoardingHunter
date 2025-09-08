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
        Schema::create(table: 'accommodations', function (Blueprint $table) {
            $table->bigIncrements(column: 'AccomodationID');
            $table->foreign(column: 'OwnerID')->references('UserID')->on('owners');
            $table->string(column: 'Name', length: 100);
            $table->enum(column: 'Type', allowed: ['Boarding']);
            $table->string(column: 'Description');
            $table->string(column: 'Location');
            $table->decimal(column: 'PricePerNight' 10, 2);
            $table->decimal(column: 'PricePerMonth' 10, 2);
            

            


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
