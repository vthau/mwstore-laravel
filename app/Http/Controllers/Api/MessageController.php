<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MessageService;
use Exception;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function get_message(Request $req)
    {
        $messages = $this->messageService->getById($req);
        return $this->successResponse($messages);
    }

    public function new_message(Request $req)
    {
        try {
            $this->messageService->save($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
