<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('ReviewID');
            
            // Foreign keys
            $table->unsignedBigInteger('SeekerID');
            $table->unsignedBigInteger('AccommodationID');
            $table->text('review');

            $table->foreign('SeekerID')
                  ->references('UserID')
                  ->on('seekers')
                  ->onDelete('cascade');

            $table->foreign('AccommodationID')
                  ->references('AccommodationID')
                  ->on('accommodations')
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
