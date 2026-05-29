<?php

use Faker\Generator as Faker;

$factory->define(App\BookSubscription::class, function (Faker $faker) {
    $addr = factory(App\Address::class)
        ->create()
        ->first();

    return [
        'address_id' => $addr->id,
    ];
});
