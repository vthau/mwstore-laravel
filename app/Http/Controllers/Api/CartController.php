<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use Exception;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(Request $req)
    {
        try {
            $this->cartService->updateOrSave($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function get_cart()
    {
        $result = $this->cartService->getByUser();
        return $this->successResponse($result);
    }

    public function get_cart_checked()
    {
        $result = $this->cartService->getByChecked();
        return $this->successResponse($result);
    }

    public function checked(Request $req)
    {
        try {
            $this->cartService->checked($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete(Request $req)
    {
        try {
            $this->cartService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
