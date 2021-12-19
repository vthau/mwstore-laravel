<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function get_address()
    {
        $address = $this->addressService->getAll();
        return $this->successResponse($address);
    }

    public function calc_feeship(Request $req)
    {
        $result = $this->addressService->calcFeeship($req);
        return $this->successResponse($result);
    }
}
