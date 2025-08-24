<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\User\RegisterNewUser;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, RegisterNewUser $registerNewUser): JsonResponse
    {

        if (!$registerNewUser(request: $request)) {
            return response()->json(['message' =>  __('Registration failed.')], 422);
        }

        return response()->json([
            'message' =>  __('Registered. Please check your email for verification link.')
        ], 201);
    }
}
