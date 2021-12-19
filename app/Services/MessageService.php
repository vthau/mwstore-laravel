<?php

namespace App\Services;

use App\Repositories\MessageRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class MessageService
{
    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function getById($data)
    {
        return $this->messageRepository->getById($data);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $this->messageRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }
}
