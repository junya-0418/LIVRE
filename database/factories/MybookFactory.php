<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Mybook::class, function (Faker $faker) {
    return [
        'user_id' => function() { return factory(App\User::class);},
        'book_id' => Str::random(12),
        'title' => 'test',
        'imageLinks' => 'http://books.google.com/books/content?id=test',
        'author1' => '東野圭吾',
        'publisher' => '早川書房',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
