<?php

namespace App\Services;


use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getCount()
    {
        return $this->commentRepository->getCount();
    }

    public function getByUser($data)
    {
        return $this->commentRepository->getByUser($data);
    }

    public function getByProduct($data)
    {
        return $this->commentRepository->getByProduct($data);
    }

    public function getAll()
    {
        return $this->commentRepository->getAll();
    }

    public function getNotConfirm()
    {
        return $this->commentRepository->getNotConfirm();
    }

    public function updateOrSave($data)
    {
        DB::beginTransaction();

        try {
            $this->commentRepository->updateOrSave($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function confirm($data)
    {
        DB::beginTransaction();

        try {
            $this->commentRepository->confirm($data);
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
            $this->commentRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function deleteByAdmin($data)
    {
        DB::beginTransaction();

        try {
            $this->commentRepository->deleteByAdmin($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }
}
