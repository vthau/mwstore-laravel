<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PostService;
use Exception;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function all_post()
    {
        $posts = $this->postService->getAll();
        return $this->successResponse($posts);
    }

    public function get_post(Request $req)
    {
        $post = $this->postService->getById($req);
        return $this->successResponse($post);
    }

    public function update_post(Request $req)
    {
        try {
            $this->postService->updateOrSave($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_post(Request $req)
    {
        try {
            $this->postService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
