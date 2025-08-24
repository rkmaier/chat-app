<?php

namespace App\Http\Actions\Friend;

use App\Http\Repository\FriendRepository;
use App\Models\Friend;

class FriendRequest
{
    private FriendRepository $friendRepository;

    public function __construct()
    {
        $this->friendRepository = new FriendRepository();
    }

    public function __invoke($user_id, $friend_id): Friend
    {
        return $this->friendRepository->friendRequest($user_id, $friend_id);
    }
}
