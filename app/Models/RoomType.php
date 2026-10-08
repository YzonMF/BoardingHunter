<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * An accommodation type managed by admins. Accommodations store the type's name.
 */
class RoomType extends Model
{
    protected $table = 'room_types';

    protected $primaryKey = 'RoomTypeID';

    public $timestamps = false;

    protected $fillable = ['name', 'sort_order'];

    /** Type names in display order. */
    public static function names(): array
    {
        return static::query()->orderBy('sort_order')->orderBy('name')->pluck('name')->all();
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'Type', 'name');
    }

}
