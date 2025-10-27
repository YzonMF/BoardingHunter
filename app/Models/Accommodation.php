<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_owner_id',
        'name',
        'address',
        'price',
        'description',
        'status'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'room_owner_id');
    }
}
