<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    /** Statuses in which a room can be reserved or booked. */
    public const OPEN_STATUSES = ['active', 'available'];

    /** Status a room returns to when a reservation or booking is released. */
    public const RELEASED_STATUS = 'active';

    protected $primaryKey = 'AccommodationID';

    // Tell Laravel you're NOT using the default timestamp columns
    public $timestamps = false;

    // OR map to your custom column name
    const CREATED_AT = 'date_created';
    const UPDATED_AT = null; // You don't have updated_at

    protected $fillable = [
        'OwnerID',
        'Name',
        'Type',
        'Description',
        'Location',
        'PricePerNight',
        'PricePerMonth',
        'status'
    ];

    // Add this to make date_created work like created_at
    protected $dates = ['date_created'];

    public function photos()
    {
        return $this->hasMany(Photo::class, 'AccommodationID', 'AccommodationID');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'OwnerID', 'UserID');
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class, 'AccommodationID', 'AccommodationID');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'AccommodationID', 'AccommodationID');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'AccommodationID', 'AccommodationID');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'AccommodationID', 'AccommodationID');
    }

    public function isOpen(): bool
    {
        return in_array($this->status, self::OPEN_STATUSES, true);
    }
}
