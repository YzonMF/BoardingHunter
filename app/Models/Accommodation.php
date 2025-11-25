<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $primaryKey = 'AccommodationID';
    
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

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'OwnerID', 'UserID');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'AccommodationID');
    }
    
    // Helper method to get first photo or default
    public function getFirstPhoto()
    {
        return $this->photos->first() ?? null;
    }
}