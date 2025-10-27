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
        Schema::create(table: 'amenities', callback: function (Blueprint $table) {
            $table->unsignedBigInteger(column: 'AmenityID')->primary();
            $table->unsignedBigInteger('AccommodationID');
            $table->foreign(columns:'AccommodationID')->references(columns: 'AccommodationID')->on(table: 'accommodations')->onDelete(action:'cascade');
            $table->string(column:'AmenityName', length:100);
            $table->string(column:'Description', length:500);
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
