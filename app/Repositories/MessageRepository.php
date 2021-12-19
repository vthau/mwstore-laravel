<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getById($data)
    {
        return $this->message->with(["user", "admin"])
            ->where(["user_id" => $data->user_id, "admin_id" => $data->admin_id])->get();
    }

    public function save($data)
    {
        $this->message->create($data->all());
    }
}
