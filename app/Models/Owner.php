<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $primaryKey = 'UserID';
    public $incrementing = false;

    // The table has no created_at/updated_at columns.
    public $timestamps = false;
    
    protected $fillable = [
        'UserID',
        'BusinessName'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    /** Business name if the owner set one, otherwise their own name. */
    public function displayName(): string
    {
        return $this->BusinessName ?: ($this->user->fullname ?? 'N/A');
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'OwnerID', 'UserID');
    }
}