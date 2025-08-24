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
            return response()->json(['message' => 'Email verified.']);
        }
        return response()->json(['message' => 'Email already verified.'], 401);
    }
}
