<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id','name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }

    public function isFollowedBy(?User $user)
    {
        return $user
            ? $this->followers->where('id', $user->id)->count()
            : 0;
    }

    public function wants(): BelongsToMany
    {
        return $this->belongsToMany('App\Mybook', 'wants', 'user_id', 'mybook_id')->withTimestamps();
    }

    public function followingBooks():  HasManyThrough
    {
        return $this->hasManyThrough(
            'App\Mybook',
            'App\Follow',
            'follower_id', // followsテーブルの外部キー
            'user_id', // bookテーブルの外部キー
            'id', // userテーブルのローカルキー
            'followee_id' // followsテーブルのローカルキー
        )->with(['owner']);
    }
}
