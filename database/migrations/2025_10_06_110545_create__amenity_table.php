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
        Schema::create('_amenity', function (Blueprint $table) {
            $table->bigIncrements(AmenityID);
            $table->int(AccommodationID);
             $table->string(AmenityName, 100);
              $table->text(Description);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_amenity');
    }
};
