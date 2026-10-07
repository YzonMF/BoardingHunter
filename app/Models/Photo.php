<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $primaryKey = 'PhotoID';
    
    // Photos table doesn't have timestamps at all
    public $timestamps = false;
    
    protected $fillable = [
        'AccommodationID',
        'FilePathURL',
        'Caption'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID', 'AccommodationID');
    }
}