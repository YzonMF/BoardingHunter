<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    protected $primaryKey = 'UserID';
    
    public $incrementing = false;

    // The table has no created_at/updated_at columns.
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'Preferences'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}