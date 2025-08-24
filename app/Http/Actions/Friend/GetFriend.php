<?php

namespace App\Http\Actions\Friend;

use App\Http\Repository\FriendRepository;
use App\Models\Friend;

class GetFriend
{
    private $repository;

    public function __construct()
    {
        $this->repository = new FriendRepository();
    }

    public function __invoke(int $user_id, int $friend_id): Friend
    {
        [$user_id, $friend_id] = $user_id < $friend_id ? [$user_id, $friend_id] : [$friend_id, $user_id];

        return $this->repository->getFriend($user_id, $friend_id);

    }
}
