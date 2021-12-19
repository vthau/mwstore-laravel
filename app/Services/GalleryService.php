<?php

namespace App\Services;

use App\Repositories\GalleryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class GalleryService
{
    protected $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    public function getById($data)
    {
        return $this->galleryRepository->getById($data);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $this->galleryRepository->save($data);
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
            $this->galleryRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }
}
