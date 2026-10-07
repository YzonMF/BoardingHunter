<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $primaryKey = 'ReviewID';

    // The table only has ReviewDate, not created_at/updated_at.
    public $timestamps = false;

    protected $fillable = [
        'SeekerID',
        'AccommodationID',
        'Rating',
        'Comment',
        'ReviewDate',
    ];

    protected $casts = [
        'Rating' => 'integer',
        'ReviewDate' => 'datetime',
    ];

    public function seeker()
    {
        return $this->belongsTo(User::class, 'SeekerID', 'UserID');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID', 'AccommodationID');
    }
}
