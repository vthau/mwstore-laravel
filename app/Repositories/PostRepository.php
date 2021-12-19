<?php

namespace App\Repositories;

use App\Models\PostProduct;

class PostRepository
{
    protected $post;

    public function __construct(PostProduct $post)
    {
        $this->post = $post;
    }

    public function getAll()
    {
        return $this->post->with("product")->get();
    }

    public function getById($data)
    {
        return $this->post->with("product")->find($data->id);
    }

    public function updateOrSave($data)
    {
        return $this->post->updateOrCreate(['product_id' => $data->product_id], $data->only("title", "content"));
    }

    public function delete($data)
    {
        return $this->post->find($data->id)->delete();
    }
}
