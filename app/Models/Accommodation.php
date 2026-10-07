<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    /** Accommodation types (matches the `Type` enum column). */
    public const TYPES = ['Boarding', 'Transient', 'Hotel'];

    /** Every status a room can have; reserved and booked are set by the system. */
    public const STATUSES = ['active', 'available', 'reserved', 'booked', 'inactive'];

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

    /** Rooms as shown on cards: photos, owner name and average rating loaded in one go. */
    public function scopeCard($query)
    {
        return $query->with(['photos', 'owner.user'])
            ->withAvg('reviews', 'Rating')
            ->withCount('reviews');
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
