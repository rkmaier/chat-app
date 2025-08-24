<?php

namespace App\Http\Actions\User;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterNewUser
{
    public function __invoke(RegisterRequest $request): bool
    {
        try {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]);

            event(new Registered($user));
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
