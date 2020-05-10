<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mybook extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'imageLinks',
        'author1',
        'publisher',
        'description',
    ];

    public function owner() {

        return $this->belongsTo('App\User', 'user_id', 'id', 'users');

    }

    public function wants(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'wants')->withTimestamps();
    }

    public function isWantedBy(?User $user)
    {
        return $user
            ? $this->wants->where('id', $user->id)->count()
            : 0;
    }

    public function getCountWantsAttribute(): int {
        return $this->wants()->count();
    }
}
