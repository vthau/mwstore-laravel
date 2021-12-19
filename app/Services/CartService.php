<?php

namespace App\Services;


use App\Repositories\CartRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CartService
{
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getByUser()
    {
        return $this->cartRepository->getByUser();
    }

    public function getByChecked()
    {
        return $this->cartRepository->getByChecked();
    }

    public function updateOrSave($data)
    {
        DB::beginTransaction();

        try {
            $this->cartRepository->updateOrSave($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function checked($data)
    {
        DB::beginTransaction();

        try {
            $this->cartRepository->checked($data);
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
            $this->cartRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }
}
