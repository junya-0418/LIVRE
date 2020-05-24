<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class UserController extends Controller
{

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function show($id) {

        $user = User::where('id', $id)->first();

        $myBooks = $this->user_repository->getMyBooks($user->id);

        $followings = $user->followings()->get();
        $followers = $user->followers()->get();

        return ['mybooks' => $myBooks, 'username' => $user->name, 'followings' => $followings, 'followers' => $followers];

    }

    public function userCheck() {

        return Auth::user();

    }

    public function followCheck($id) {

        $user = User::where('id', $id)->first();

        return $user->isFollowedBy(Auth::user());

    }

    public function follow(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return $user->followers()->get();
    }

    public function unfollow(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return $user->followers()->get();
    }
}
