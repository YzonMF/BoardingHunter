<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $primaryKey = 'InquiryID';

    protected $fillable = [
        'SeekerID',
        'OwnerID',
        'AccommodationID',
        'Message',
        'DateSent',
        'Reply',
        'RepliedAt',
        'Status',
    ];

    protected $casts = [
        'DateSent' => 'datetime',
        'RepliedAt' => 'datetime',
    ];

    public function seeker()
    {
        return $this->belongsTo(User::class, 'SeekerID', 'UserID');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'OwnerID', 'UserID');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID', 'AccommodationID');
    }
}
