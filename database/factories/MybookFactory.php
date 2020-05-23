<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Mybook::class, function (Faker $faker) {
    return [
        'id' => Str::random(12),
        'user_id' => fn() => factory(App\User::class)->create()->id,
        'book_id' => Str::random(12),
        'title' => 'test',
        'imageLinks' => 'http://books.google.com/books/content?id=test',
        'author1' => '東野圭吾',
        'publisher' => '早川書房',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
