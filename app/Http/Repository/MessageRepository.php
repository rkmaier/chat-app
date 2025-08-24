<?php

namespace App\Http\Repository;

use App\Models\Message;
use Illuminate\Pagination\LengthAwarePaginator;

class MessageRepository
{
    public function getMessage($perPage): LengthAwarePaginator
    {
        return Message::query()
            ->orderBy('created_at')
            ->paginate($perPage);
    }

    public function searchMessages($auth, $withUser, $perPage): LengthAwarePaginator
    {
        return Message::query()
            ->where(function ($q) use ($auth, $withUser) {
                $q->where('sender_id', $auth->id)->where('receiver_id', $withUser->id);
            })
            ->orWhere(function ($q) use ($auth, $withUser) {
                $q->where('sender_id', $withUser->id)->where('receiver_id', $auth->id);
            })
            ->orderBy('created_at', 'asc')
            ->paginate($perPage);
    }
}
