<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,10),
        'name' => $faker->name,
        'url' =>  $faker->url,
        'description' => $faker->sentence,
    ];
});
