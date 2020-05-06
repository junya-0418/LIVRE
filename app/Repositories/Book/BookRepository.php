<?php

namespace App\Repositories\Book;

use App\Mybook;

class BookRepository implements BookRepositoryInterface
{
    protected $mybook;

    /**
     * @param object mybook
     */
    public function __construct(Mybook $mybook)
    {
        $this->mybook = $mybook;
    }

    /**
     * 名前で1レコードを取得
     *
     * @var $name
     * @return object
     */
    public function getMyBooksFromUserId($user_id)
    {
        return Mybook::where('user_id', $user_id)->take(10)->get();
    }
}
