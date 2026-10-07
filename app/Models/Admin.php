<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $primaryKey = 'UserID';
    
    public $incrementing = false;

    protected $fillable = [
        'UserID',
        'AccessLevel'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}