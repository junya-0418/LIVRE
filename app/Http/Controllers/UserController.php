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

//        $display_follow_button = true;

//        if(Auth::check()) {
//            if (Auth::user()->id === $user->id) {
//                $display_follow_button = false;
//            }
//        } else {
//            $display_follow_button = true;
//        }
//
//        $followingsCounts = $user->followings()->get()->count();
//        $followersCounts = $user->followers()->get()->count();

        return ['mybooks' => $myBooks, 'username' => $user->name];

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

        return $user->followers()->get()->count();
    }

    public function unfollow(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return $user->followers()->get()->count();
    }
}
