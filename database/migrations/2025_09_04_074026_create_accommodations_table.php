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
        Schema::create('photos', function (Blueprint $table) {
            $table->id('PhotoID');
            $table->string('FilePathURL', 255);
            $table->string('Caption', 255)->nullable();
        });

         Schema::create('accommodations', function (Blueprint $table) {
            $table->bigIncrements('AccommodationID');
            $table->unsignedBigInteger('OwnerID');
            $table->string('Name', 100);
            $table->enum('Type',['Boarding','Transient','Hotel']);
            $table->string('Description');
            $table->string('Location');
            $table->decimal('PricePerNight', 10, 2);
            $table->decimal('PricePerMonth', 10, 2);
            $table->unsignedBiginteger('PhotoID');

            $table->foreign('PhotoID')
                ->references('PhotoID')
                ->on('photos')
                ->onDelete('cascade');

            $table->foreign('OwnerID')
                  ->references('UserID')
                  ->on('owners')
                  ->onDelete('cascade');
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
