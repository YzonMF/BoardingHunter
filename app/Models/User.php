<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'UserID';
    
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'contactnum',
        'Role'
    ];

    protected $hidden = [
        'password',
    ];
    
    protected $casts = [
        'dateJoined' => 'datetime',
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class, 'UserID');
    }

    public function owner()
    {
        return $this->hasOne(Owner::class, 'UserID');

    }

    public function seeker()
    {
        return $this->hasOne(Seeker::class, 'UserID');
    }
}