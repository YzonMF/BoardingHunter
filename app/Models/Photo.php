<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    /** Deletes the uploaded file; seeded photos are external URLs and are left alone. */
    public function deleteStoredFile(): void
    {
        if (str_starts_with($this->FilePathURL, '/storage/')) {
            Storage::disk('public')->delete(substr($this->FilePathURL, strlen('/storage/')));
        }
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID', 'AccommodationID');
    }
}