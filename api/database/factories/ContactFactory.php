<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    $dob = $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-20 years');
    return [
        'member_id' => rand(1,10),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
        'phone' => 9815231238,
        'dob' => $dob,
        'photo_url' => $faker->imageUrl(),
        'description' => $faker->text,

    ];
});
