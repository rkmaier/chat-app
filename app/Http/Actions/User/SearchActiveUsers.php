<?php

namespace App\Http\Actions\User;

use App\Http\Repository\UserRepository;

class SearchActiveUsers
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(string $q, $perPage)
    {
        return $this->userRepository->searchActiveUsers(q: $q, perPage: $perPage);
    }
}
