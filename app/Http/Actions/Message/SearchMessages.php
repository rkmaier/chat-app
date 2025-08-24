<?php

namespace App\Http\Actions\Message;

use App\Http\Repository\MessageRepository;
use App\Models\User;
use Illuminate\Http\Request;

class SearchMessages
{
    private MessageRepository $messageRepo;

    public function __construct()
    {
        $this->messageRepo = new MessageRepository();
    }

    public function __invoke(Request $request, User $withUser)
    {
        $perPage = $request->integer('per_page', 20);
        $auth = $request->user();
        return $this->messageRepo->searchMessages(auth: $auth, withUser: $withUser, perPage: $perPage);
    }

}
