<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CommentService;
use Exception;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function get_comment(Request $req)
    {
        $comment = $this->commentService->getByUser($req);
        return $this->successResponse($comment);
    }

    public function get_product_comment(Request $req)
    {
        $comments = $this->commentService->getByProduct($req);
        return $this->successResponse($comments);
    }

    public function update_comment(Request $req)
    {
        try {
            $this->commentService->updateOrSave($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_comment(Request $req)
    {
        try {
            $this->commentService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function all_comment()
    {
        $comments = $this->commentService->getAll();
        return $this->successResponse($comments);
    }

    public function notconfirm_comment()
    {
        $comments = $this->commentService->getNotConfirm();
        return $this->successResponse($comments);
    }

    public function delete_comment_admin(Request $req)
    {
        try {
            $this->commentService->deleteByAdmin($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function confirm_comment(Request $req)
    {
        try {
            $this->commentService->confirm($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
