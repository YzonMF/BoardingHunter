<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $primaryKey = 'UserID';
    public $incrementing = false;
    
    protected $fillable = [
        'UserID',
        'BusinessName'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'OwnerID', 'UserID');
    }
}