<?php

namespace App\Http\Actions\User;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyUserEmail
{
    public function __invoke(Request $request): bool
    {
        $id = ($request->route('id'));
        $user = User::find($id);

        if (!hash_equals((string)$user->getKey(), (string)$request->route('id'))) {
            return false;
        }

        if (!hash_equals(sha1($user->getEmailForVerification()), (string)$request->route('hash'))) {
            return false;
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            return true;
        } else {
            return false;
        }
    }
}
