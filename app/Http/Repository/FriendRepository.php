<?php

namespace App\Http\Repository;

use App\Models\Friend;

class FriendRepository
{
    public function getFriend($user_id, $friend_id): Friend
    {
        return Friend::firstOrNew(['user_id' => $user_id, 'friend_id' => $friend_id]);
    }

    public function friendRequest($user_id, $friend_id): Friend
    {
        return Friend::between($user_id, $friend_id)->first();
    }
}
