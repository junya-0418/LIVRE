<?php

namespace App\Services;

class BookService
{
    public function getBookInformationFromGoogleBooksApi($query)
    {
        $data = "https://www.googleapis.com/books/v1/volumes?q=".$query."&country=JP";
        $json = file_get_contents($data);
        $json_decode = json_decode($json);

        // jsonデータ内の『entry』部分を複数取得して、postsに格納
        $posts = $json_decode->items;

        return $posts;
    }
}
