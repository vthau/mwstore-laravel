<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use Exception;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAll();
        return $this->successResponse($orders);
    }

    public function show($id)
    {
        $order = $this->orderService->getById($id);
        return $this->successResponse($order);
    }

    public function new_order(OrderRequest $req)
    {
        try {
            $result = $this->orderService->save($req);
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function callback(Request $req)
    {
        try {
            $result = $this->orderService->callbackPayment($req);
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function all_order()
    {
        $orders = $this->orderService->getAllByAdmin();
        return $this->successResponse($orders);
    }

    public function confirm_order(Request $req)
    {
        try {
            $result = $this->orderService->confirmOrder($req);
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_order(Request $req)
    {
        try {
            $this->orderService->confirmOrder($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function order_detail(Request $req)
    {
        $order = $this->orderService->getByCode($req->code);
        return $this->successResponse($order);
    }

    public function print_order($code)
    {
        try {
            $file = $this->orderService->exportPDF($code);
            return $file;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
