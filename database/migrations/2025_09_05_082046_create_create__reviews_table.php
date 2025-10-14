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
            $table->foreignId('SeekerID')
                  ->constrained('seekers', 'UserID')
                  ->onDelete('cascade'); 
            $table->foreignId('AccommodationID')
                  ->constrained('accommodations', 'AccommodationID')
                  ->onDelete('cascade'); 
            $table->unsignedTinyInteger('Rating'); 
            $table->text('Comment')->nullable();
            $table->timestamp('ReviewDate')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
