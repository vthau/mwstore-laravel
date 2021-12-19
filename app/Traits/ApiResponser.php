<?php

namespace App\Traits;

trait ApiResponser
{

    protected function successResponse($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'SUCCESS',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = null, $code = 200)
    {
        return response()->json([
            'status' => 'FAIL',
            'message' => $message,
            'data' => null
        ], $code);
    }
}
