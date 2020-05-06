<?php

namespace App\Repositories\Book;

interface BookRepositoryInterface
{
    /**
     * Nameで1レコードを取得
     */
    public function getMyBooksFromUserId($user_id);
}
