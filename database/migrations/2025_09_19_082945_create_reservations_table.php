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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('ReservationID');
            $table->unsignedBigInteger('SeekerID');
            $table->unsignedBigInteger('AccommodationID');
            $table->date('CheckInDate');
            $table->date('DueDate');
            $table->timestamp('ReservationDate')->useCurrent();
            $table->enum('Status', ['Pending','Confirmed','Rejected','Cancelled'])->default('Pending');
            $table->text('SpecialRequests')->nullable();
            $table->text('OwnerResponse')->nullable();

            $table->foreign('SeekerID')->references('UserID')->on('seekers')->cascadeOnDelete();
            $table->foreign('AccommodationID')->references('AccommodationID')->on('accommodations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
