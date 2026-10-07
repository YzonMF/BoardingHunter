<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
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

}
