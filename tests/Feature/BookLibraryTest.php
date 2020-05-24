<?php

namespace Tests\Feature;

use App\Mybook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookLibraryTest extends TestCase
{
    use DatabaseTransactions;

    //トップページ表示テスト
    public function testIndex() {

        $response = $this->get(route('top'));

        $response->assertStatus(200)
            ->assertViewIs('index');

    }

    //トップページの本データの取得テスト
    public function testGetBooksData()
    {
        // 5つの本データを生成する
        factory(Mybook::class, 5)->create();

        $response = $this
           ->json('GET', route('index'));

        // 生成した本データを作成日降順で取得
        $books = Mybook::with(['owner'])->orderBy('created_at', 'desc')->get();

        // data項目の期待値
        $expected_data = $books->map(function ($book) {
            return [
                'id' => $book->id,
                'user_id' => $book->user_id,
                'title' => $book->title,
                'imageLinks' => $book->imageLinks,
                'author1' => $book->author1,
                'publisher' => $book->publisher,
                'description' => $book->description,
                'owner' => [
                    'id' => $book->owner->id,
                    'name' => $book->owner->name,
                ],
            ];
        })
            ->all();


        $response->assertStatus(200)
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
}
