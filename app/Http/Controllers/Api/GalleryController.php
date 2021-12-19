<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GalleryService;
use Exception;

class GalleryController extends Controller
{
    protected $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    public function gallery_product(Request $req)
    {
        $gallerys = $this->galleryService->getById($req);
        return $this->successResponse($gallerys);
    }

    public function new_gallery(Request $req)
    {
        try {
            $this->galleryService->save($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_gallery(Request $req)
    {
        try {
            $this->galleryService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
