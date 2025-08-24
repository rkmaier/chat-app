<?php

namespace App\Http\Repository;

use App\Models\User;

class UserRepository
{
    public function searchActiveUsers(string $q, $perPage)
    {
        return User::query()
            ->active()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->paginate($perPage);
    }
}
