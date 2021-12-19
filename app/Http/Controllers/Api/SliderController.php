<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SliderService;
use Exception;

class SliderController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function get_slider()
    {
        $sliders = $this->sliderService->getLimit();
        return $this->successResponse($sliders);
    }

    public function all_slider()
    {
        $sliders = $this->sliderService->getAll();
        return $this->successResponse($sliders);
    }

    public function new_slider(Request $req)
    {
        try {
            $this->sliderService->save($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_slider(Request $req)
    {
        try {
            $this->sliderService->update($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_slider(Request $req)
    {
        try {
            $this->sliderService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
