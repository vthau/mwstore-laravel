<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    protected $comment;


    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getCount()
    {
        return $this->comment->count();
    }

    public function getByUser($data)
    {
        $user_id = auth()->user()->id;
        return $this->comment->with('user')->where(['user_id' => $user_id, 'product_id' => $data->product_id])->get();
    }

    public function getByProduct($data)
    {
        return $this->comment->with('user')->where(['product_id' => $data->product_id, 'status' => 1])->latest('id')->get();
    }

    public function getAll()
    {
        return $this->comment->with(["user", "product"])->latest('id')->get();
    }

    public function confirm($data)
    {
        return $this->comment->find($data->id)->update(['status' => 1]);
    }

    public function getNotConfirm()
    {
        return $this->comment->with(["user", "product"])->where("status", 0)->latest('id')->get();
    }

    public function updateOrSave($data)
    {
        $user_id = auth()->user()->id;
        $comment = $this->comment->updateOrCreate([
            'user_id'   =>  $user_id,
            'product_id'   =>  $data->product_id,
        ], ['star' => $data->star, 'comment' => $data->comment]);
        return $comment->fresh();
    }

    public function delete($data)
    {
        $user_id = auth()->user()->id;
        return $this->comment->where(['user_id' => $user_id, 'product_id' => $data->product_id])->first()->delete();
    }

    public function deleteByAdmin($data)
    {
        return $this->comment->find($data->id)->delete();
    }
}
