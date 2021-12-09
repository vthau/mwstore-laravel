<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
  public function index()
  {
    $comments =  Comment::with('user')->get();
    return view('admin.comment.list')->with(compact(['comments']));
  }

  public function get_not_confirm()
  {
    $comments =  Comment::with('user')->where('status', 0)->get();
    return view('admin.comment.not-confirm')->with(compact(['comments']));
  }

  public function set_confirm($id)
  {
    Comment::where('id', $id)->update(['status' => 1]);
    return back();
  }

  public function store(CommentRequest $req)
  {
    $comment = new Comment;
    $comment->user_id = Auth::user()->id;
    $comment->fill($req->all());
    $comment->save();
  }

  public function update(CommentRequest $req)
  {
    Comment::where([
      'user_id' => Auth::user()->id,
      'product_id' => $req->product_id,
    ])->update($req->only(['product_id', 'comment', 'star']));
  }

  public function delete(Request $req)
  {
    Comment::find($req->id)->delete();
  }
}
