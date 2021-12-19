<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class NotificationService
{
    protected $feeshipRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function getTokenByUser($data)
    {
        return $this->notificationRepository->getTokenByUser($data);
    }

    public function getAll()
    {
        return $this->notificationRepository->getAll();
    }

    public function saveUser($data)
    {
        DB::beginTransaction();

        try {
            $this->notificationRepository->saveUser($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function saveGuest($data)
    {
        DB::beginTransaction();

        try {
            $this->notificationRepository->saveGuest($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }
}
