<?php

namespace App\Http\Actions\Message;

use App\Http\Repository\MessageRepository;
use Illuminate\Http\Request;

class GetMessages
{
    private MessageRepository $messageRepo;

    public function __construct()
    {
        $this->messageRepo = new MessageRepository();
    }

    public function __invoke(Request $request)
    {
        $perPage = $request->integer('per_page', 20);
        return $this->messageRepo->getMessage($perPage);
    }
}
