<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AppNotification;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;

    protected $primaryKey = 'UserID';
    
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'contactnum',
        'role'
    ];

    protected $hidden = [
        'password',
    ];
    


    /** Sends an in-app notification that links to the relevant page. */
    public function notifyApp(string $message, string $url): void
    {
        $this->notify(new AppNotification($message, $url));
    }

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