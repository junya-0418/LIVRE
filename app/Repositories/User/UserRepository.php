<?php

namespace App\Repositories\User;

use App\User;
use App\Mybook;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    /**
     * @param object user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return object
     */
    public function getMyBooks($user_id)
    {
        return Mybook::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(10);
    }
}
