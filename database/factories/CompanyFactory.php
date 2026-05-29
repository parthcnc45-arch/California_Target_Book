<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    $addr = factory(App\Address::class)
        ->create()
        ->first();

    return [
        'name' => $faker->company,
        'address_id' => $addr->id,
    ];
});
