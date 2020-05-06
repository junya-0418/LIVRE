<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function getMyBooks($user_id);
}
