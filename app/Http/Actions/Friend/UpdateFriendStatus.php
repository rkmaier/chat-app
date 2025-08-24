<?php

namespace App\Http\Actions\Friend;

use App\Models\Friend;

class UpdateFriendStatus
{
    public function __invoke(Friend $friend, $status, $authId = false): bool
    {
        $friend->status = $status;
        if ($authId) {
            $friend->requested_by = $authId;
        }
        return $friend->save();
    }
}
