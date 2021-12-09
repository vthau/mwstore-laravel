<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function get_comment(Request $req)
    {
        $user_id = auth()->user()->id;
        $comment = Comment::with('user')->where(['user_id' => $user_id, 'product_id' => $req->product_id])->get();

        if ($comment) {
            return response()->json([
                'status' => "SUCCESS",
                'comment' => $comment,
            ]);
        }

        return $comment;
    }

    public function get_product_comment(Request $req)
    {
        $comments = Comment::with('user')->where(['product_id' => $req->product_id, 'status' => 1])->latest('id')->get();

        if ($comments) {
            return response()->json([
                'status' => "SUCCESS",
                'comments' => $comments,
            ]);
        }

        return $comments;
    }

    public function update_comment(Request $req)
    {
        $user_id = auth()->user()->id;

        $comment =  Comment::updateOrCreate([
            'user_id'   =>  $user_id,
            'product_id'   =>  $req->product_id,
        ], ['star' => $req->star, 'comment' => $req->comment]);

        if ($comment) {
            Activity::addComment();
            return response()->json([
                "status" => "SUCCESS",
            ]);
        }

        return $comment;
    }

    public function delete_comment(Request $req)
    {
        $user_id = auth()->user()->id;
        Comment::where(['user_id' => $user_id, 'product_id' => $req->product_id])->first()->delete();
        Activity::deleteComment();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function all_comment()
    {
        $comments = Comment::with(["user", "product"])->latest('id')->get();
        return response()->json([
            "status" => "SUCCESS",
            "comments" => $comments,
        ]);
    }

    public function notconfirm_comment()
    {
        $comments = Comment::with(["user", "product"])->where("status", 0)->latest('id')->get();
        return response()->json([
            "status" => "SUCCESS",
            "comments" => $comments,
        ]);
    }

    public function delete_comment_admin(Request $req)
    {
        Comment::find($req->id)->delete();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function confirm_comment(Request $req)
    {
        Comment::where("id", $req->id)->update(['status' => 1]);
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }
}
