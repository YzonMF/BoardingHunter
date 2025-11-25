<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // In your migration file
public function up(): void
{

    Schema::create('accommodations', function (Blueprint $table) {
        $table->bigIncrements('AccommodationID');
        $table->unsignedBigInteger('OwnerID');
        $table->string('Name', 100);
        $table->enum('Type', ['Boarding', 'Transient', 'Hotel']);
        $table->text('Description');
        $table->string('Location');
        $table->decimal('PricePerNight', 10, 2);
        $table->decimal('PricePerMonth', 10, 2);
        $table->string('status')->default('active');
        $table->timestamp('date_created')->usecurrent();

        $table->foreign('OwnerID')
              ->references('UserID')
              ->on('owners')
              ->onDelete('cascade');
    });

    Schema::create('photos', function (Blueprint $table) {
        $table->bigIncrements('PhotoID');
        $table->unsignedBigInteger('AccommodationID');
        $table->string('FilePathURL', 255);
        $table->string('Caption', 255)->nullable();
        
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
        Schema::dropIfExists('accommodations');
    }
};
