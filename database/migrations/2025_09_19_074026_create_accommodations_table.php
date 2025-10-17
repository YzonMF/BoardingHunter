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
        Schema::create('accommodations', function (Blueprint $table) { // Change to plural
            $table->bigIncrements('AccommodationID');
            $table->unsignedBigInteger('OwnerID');
            $table->string('Name', 100);
            $table->enum('Type',['Boarding','Transient','Hotel']);
            $table->text('Description'); // Changed to text
            $table->string('Location');
            $table->decimal('PricePerNight', 10, 2);
            $table->decimal('PricePerMonth', 10, 2);
            
            // Add foreign key
            $table->foreign('OwnerID')->references('UserID')->on('owners')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodations'); // Consistent name
    }
};
