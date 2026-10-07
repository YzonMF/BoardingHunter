<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $primaryKey = 'AmenityID';

    // The amenities table has no created_at/updated_at columns.
    public $timestamps = false;

    protected $fillable = [
        'AccommodationID',
        'AmenityName',
        'Description',
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID', 'AccommodationID');
    }
}
