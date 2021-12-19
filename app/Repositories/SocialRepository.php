<?php

namespace App\Repositories;

use App\Models\SocialAccount;

class SocialRepository
{
    protected $social;

    public function __construct(SocialAccount $social)
    {
        $this->social = $social;
    }

    public function getById($id)
    {
        return $this->social->where('social_id', $id)->first();
    }

    public function save($id, $name)
    {
        $social_account = new $this->social;
        $social_account->social_id = $id;
        $social_account->social_name = $name;
        $social_account->save();
        $social_account->fresh();
        return $social_account;
    }
}
