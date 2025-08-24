<?php

namespace App\Http\Actions\Message;

use App\Http\Requests\MessageRequest;
use App\Models\Message;

class CreateMessage
{
    public function __invoke($sender, $recipient, MessageRequest $request): Message
    {
        $message = Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $recipient->id,
            'body' => $request->validated('body'),
        ]);

        return $message;
    }
}
