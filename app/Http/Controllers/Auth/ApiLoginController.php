<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\User\AuthenticateUser;
use App\Http\Actions\User\UserEmailNotVerified;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class ApiLoginController extends Controller
{
    public function login(LoginRequest $request, AuthenticateUser $authenticateUser, UserEmailNotVerified $userEmailNotVerified): JsonResponse
    {
        if ($authenticateUser($request)) {
            return response()->json(['message' => __('Invalid credentials')], 422);
        }

        $user = $request->user();

        if (!$userEmailNotVerified) {
            return response()->json(['message' => __('Email not verified')], 403);
        }

        return response()->json([
            'token' => $user->createApiToken(),
            'token_type' => 'Bearer',
        ]);
    }


}
