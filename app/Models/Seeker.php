<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    use HasFactory;
<<<<<<< Updated upstream
}
=======

    protected $primaryKey = 'UserID';
    
    public $incrementing = false;

    protected $fillable = [
        'UserID',
        'Preferences'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
>>>>>>> Stashed changes
