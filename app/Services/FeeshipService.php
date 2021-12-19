<?php

namespace App\Services;

use App\Repositories\FeeshipRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class FeeshipService
{
    protected $feeshipRepository;

    public function __construct(FeeshipRepository $feeshipRepository)
    {
        $this->feeshipRepository = $feeshipRepository;
    }

    public function getAll()
    {
        return $this->feeshipRepository->getAll();
    }

    public function updateOrSave($data)
    {
        DB::beginTransaction();

        try {
            $this->feeshipRepository->updateOrSave($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function delete($data)
    {
        DB::beginTransaction();

        try {
            $this->feeshipRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }
}
