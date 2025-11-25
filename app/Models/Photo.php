<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Photo extends Model
{
    use HasFactory;

    protected $primaryKey = 'PhotoID';
    
    protected $fillable = [
        'AccommodationID',
        'FilePathURL',
        'Caption'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID');
    }
}