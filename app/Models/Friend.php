<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPT = 'accepted';
    const STATUS_BLOCKED = 'blocked';

    protected $fillable = [
        'user_id', 'friend_id', 'status', 'requested_by',
    ];


    protected $casts = [
        'user_id' => 'integer',
        'friend_id' => 'integer',
    ];


    public function scopeBetween($query, int $user_id, int $friend_id)
    {
        [$user_id, $friend_id] = $user_id < $friend_id ? [$user_id, $friend_id] : [$friend_id, $user_id];
        return $query->where('user_id', $user_id)->where('friend_id', $friend_id);
    }
}
