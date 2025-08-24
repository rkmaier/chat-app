<?php

namespace App\Http\Controllers;

use App\Http\Actions\Friend\FriendRequest;
use App\Http\Actions\Message\CreateMessage;
use App\Http\Actions\Message\GetMessages;
use App\Http\Actions\Message\SearchMessages;
use App\Http\Requests\MessageRequest;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function send(MessageRequest $request, User $recipient, CreateMessage $createMessage): JsonResponse
    {
        $sender = $request->user();

        if (!($sender->id !== $recipient->id)) {
            return response()->json(['message' => __('Cannot message yourself.')], 422);
        }

        $friend = Friend::between($sender->id, $recipient->id)->first();

        if (!($friend && $friend->status === Friend::STATUS_ACCEPT)) {
            return response()->json(['message' => __('Users are not friends.')], 403);
        }

        $message = $createMessage(sender: $sender, recipient: $recipient, request: $request);

        return response()->json($message, 201);
    }


    public function search(Request $request, User $withUser, FriendRequest $friendRequest, SearchMessages $searchMessages): JsonResponse
    {
        $auth = $request->user();

        $friend = $friendRequest($auth->id, $withUser->id);

        if (!($friend && $friend->status === Friend::STATUS_ACCEPT)) {
            return response()->json(['message' => __('Users are not friends.')], 403);
        }

        $messages = $searchMessages(request: $request, withUser: $withUser);
        return response()->json($messages);
    }

    public function all(Request $request, GetMessages $getMessages): JsonResponse
    {
        $messages = $getMessages($request);
        return response()->json($messages);
    }
}
