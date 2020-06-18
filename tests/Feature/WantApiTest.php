<?php

namespace Tests\Feature;

use App\Mybook;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WantApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Mybook::class)->create();
        $this->book = Mybook::first();
    }

    /**
     * @test
     */
    public function should_読みたいを追加できる()
    {
        $response = $this->actingAs($this->user)
            ->json('PUT', route('want', [
                'id' => $this->book->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                "counts" => $this->book->wants()->count(),
            ]);

    }

    /**
     * @test
     */
    public function should_2回同じ写真にいいねしても1個しかいいねがつかない()
    {
        $param = ['id' => $this->book->id];
        $this->actingAs($this->user)->json('PUT', route('want', $param));
        $this->actingAs($this->user)->json('PUT', route('want', $param));

        $this->assertEquals(1, $this->book->wants()->where('user_id', $this->user->id)->count());
    }

    /**
     * @test
     */
    public function should_いいねを解除できる()
    {
        $this->book->wants()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->json('DELETE', route('unwant', [
                'id' => $this->book->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                "counts" => $this->book->wants()->count(),
            ]);
    }
}
