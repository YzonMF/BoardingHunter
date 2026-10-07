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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('BookingID');
            $table->unsignedBigInteger('SeekerID');
            $table->unsignedBigInteger('AccommodationID');
            // Set when the booking was made from an approved reservation.
            $table->unsignedBigInteger('ReservationID')->nullable();
            $table->date('CheckInDate');
            $table->date('CheckOutDate')->nullable();
            $table->timestamp('BookingDate')->useCurrent();
            $table->enum('Status', ['Pending','Confirmed','Rejected','Cancelled'])->default('Pending');
            $table->text('SpecialRequests')->nullable();
            $table->text('OwnerResponse')->nullable();

            $table->foreign('SeekerID')->references('UserID')->on('seekers')->cascadeOnDelete();
            $table->foreign('AccommodationID')->references('AccommodationID')->on('accommodations')->cascadeOnDelete();
            $table->foreign('ReservationID')->references('ReservationID')->on('reservations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
    
};
