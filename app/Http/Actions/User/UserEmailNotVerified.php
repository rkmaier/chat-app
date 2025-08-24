<?php

namespace App\Http\Actions\User;

use App\Models\User;

class UserEmailNotVerified
{
    public function __invoke(User $user): bool
    {
        return is_null($user->email_verified_at);
    }
}
