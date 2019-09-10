<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'member_id' => rand(1,10),
        'name' => $faker->name,
        'author' => $faker->name,
        'address' => $faker->address,
        'phone' => 9815231238,
        'description'=> $faker->sentence
    ];
});
