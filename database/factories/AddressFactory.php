<?php

use Faker\Generator as Faker;

$factory->define(App\Address::class, function (Faker $faker) {
    return [
        'line1' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip_code' => $faker->postcode,
    ];
});
