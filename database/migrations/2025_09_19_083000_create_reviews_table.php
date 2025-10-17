<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('ReviewID');
            $table->unsignedBigInteger('SeekerID'); // Change to unsignedBigInteger
            $table->unsignedBigInteger('AccommodationID'); // Change to unsignedBigInteger
            $table->unsignedTinyInteger('Rating');
            $table->text('Comment')->nullable();
            $table->timestamp('ReviewDate')->useCurrent();

            // Fix foreign key constraints
            $table->foreign('SeekerID')->references('UserID')->on('seekers')->onDelete('cascade');
            $table->foreign('AccommodationID')->references('AccommodationID')->on('accommodations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
