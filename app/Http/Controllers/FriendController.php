<?php

namespace App\Http\Controllers;

use App\Http\Actions\Friend\FriendRequest;
use App\Http\Actions\Friend\GetFriend;
use App\Http\Actions\Friend\UpdateFriendStatus;
use App\Http\Actions\User\UserEmailNotVerified;
use App\Http\Repository\FriendRepository;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    private FriendRepository $repository;

    public function __construct(FriendRepository $friendRepository)
    {
        $this->repository = $friendRepository;
    }

    public function request(Request $request, User $user, UserEmailNotVerified $emailNotVerified, UpdateFriendStatus $updateFriendStatus, GetFriend $getFriend): JsonResponse
    {
        $auth = $request->user();

        if ($emailNotVerified($user)) {
            return response()->json(['message' => __('User is not verified.')], 422);
        }

        if (!($auth->id !== $user->id)) {
            return response()->json(['message' => __('Cannot friend yourself.')], 422);
        }

        $friend = $getFriend(user_id: $auth->id, friend_id: $user->id);

        if ($friend->exists && $friend->status === Friend::STATUS_BLOCKED) {
            return response()->json(['message' => __('Friend is blocked.')], 403);
        }

        if ($friend->exists && $friend->status === Friend::STATUS_PENDING) {
            if ($friend->requested_by !== $auth->id) {
                $updateFriendStatus($friend, Friend::STATUS_ACCEPT);
                return response()->json(['message' => __('Friend request accepted.')]);
            }
            return response()->json(['message' => __('Friend request already sent.')]);
        }

        $updateFriendStatus($friend, Friend::STATUS_PENDING, $auth->id);
        return response()->json(['message' => __('Friend request sent.')]);
    }


    public function accept(Request $request, User $user, FriendRequest $friendRequest, UpdateFriendStatus $updateFriendStatus): JsonResponse
    {
        $auth = $request->user();

        if (!($auth->id !== $user->id)) {
            return response()->json(['message' => __('Invalid operation.')], 422);
        }

        $friend = $friendRequest(user_id: $auth->id, friend_id: $user->id);

        if (!$friend) {
            return response()->json(['message' => __('Friend not found.')], 404);
        }

        if (!($friend->requested_by !== $auth->id)) {
            return response()->json(['message' => __('You cannot accept your own request.')], 403);
        }

        $updateFriendStatus(friend: $friend, status: Friend::STATUS_ACCEPT);

        return response()->json(['message' => __('Friend request accepted.')]);
    }
}
