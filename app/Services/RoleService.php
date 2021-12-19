<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll()
    {
        return $this->roleRepository->getAll();
    }

    public function getById($data)
    {
        return $this->roleRepository->getById($data);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $this->roleRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function update($data)
    {
        DB::beginTransaction();

        try {
            $this->roleRepository->update($data);
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
            $this->roleRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }
}
