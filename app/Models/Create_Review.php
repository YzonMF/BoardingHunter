<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Create_Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $primaryKey = 'ReviewID';

    protected $fillable = [
        'SeekerID',
        'AccommodationID',
        'Rating',
        'Comment',
        'ReviewDate',
    ];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class, 'SeekerID', 'UserID');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID');
    }
}
