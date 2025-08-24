<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\User\VerifyUserEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyEmailController
{
    public function __invoke(Request $request, VerifyUserEmail $verifyUserEmail): JsonResponse
    {
        if ($verifyUserEmail(request: $request)) {
            return response()->json(['message' => __('Email verified.')]);
        }
        return response()->json(['message' => __('Email already verified.')], 401);
    }
}
