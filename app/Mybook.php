<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mybook extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'imageLinks',
        'author',
        'description',
        'reading_status',
    ];

    public function owner() {

        return $this->belongsTo('App\User', 'user_id', 'id', 'users');

    }
}
