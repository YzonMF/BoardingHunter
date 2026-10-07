<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    protected $table = 'community_posts';

    protected $primaryKey = 'PostID';

    // The table only has PostDate, not created_at/updated_at.
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'Title',
        'Content',
        'PostDate',
    ];

    protected $casts = [
        'PostDate' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
}
