<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $visible = [
        'content',
    ];

    protected $fillable = [
        'mybook_id', 'content',
    ];

}
