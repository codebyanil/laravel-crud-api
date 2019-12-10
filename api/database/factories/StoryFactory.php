<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Story;
use Faker\Generator as Faker;

$factory->define(Story::class, function (Faker $faker) {
    return [
        'member_id' => rand(1, 10),
        'name' => $faker->name,
        'title' => $faker->name,
        'address' => $faker->address,
        'description' => $faker->sentence
    ];
});
