<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(\App\Polls\Poll::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'starts_on' => Carbon::now()->subDay()->toDateString(),
        'ends_on' => Carbon::now()->addWeek()->toDateString(),
    ];
});
$factory->state(\App\Polls\Poll::class, 'past', function () {
    return [
        'starts_on' => Carbon::now()->subWeek()->toDateString(),
        'ends_on' => Carbon::now()->subDay()->toDateString(),
    ];
});
$factory->state(\App\Polls\Poll::class, 'future', function () {
    return [
        'starts_on' => Carbon::now()->addWeek()->toDateString(),
        'ends_on' => Carbon::now()->addWeeks(2)->toDateString(),
    ];
});

$factory->define(\App\Polls\PollQuestion::class, function (Faker $faker) {
    return [ 'text' => $faker->sentence(), 'type' => \App\Polls\PollQuestion::RANGE ];
});
$factory->define(\App\Polls\PollAnswerOption::class, function (Faker $faker) {
    return [ 'text' => $faker->sentence() ];
});

