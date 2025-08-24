<?php

namespace App\Http\Actions\User;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    public function __invoke(LoginRequest $request): bool
    {
        return !Auth::attempt(['email' => $request->get('email', ''), 'password' => $request->get('password', "")]);
    }
}
