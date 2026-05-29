<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    $company = factory(App\Company::class)
        ->create()
        ->first();

    $email = $faker->unique()->safeEmail;

    $cust = \Stripe\Customer::create([
        'email' => $email,
        'source' => 'tok_visa',
    ]);

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $email,
        'password' => $password ?: $password = bcrypt('test'),
        'remember_token' => str_random(10),
        'company_id' => $company->id,
        'verified' => 1,
        'api_token' => str_random(60),
        'stripe_id' => $cust->id,
    ];
});

$factory->state(App\User::class, 'admin', ['role' => 'admin']);

$factory->state(App\User::class, 'active', function(Faker $faker) {

    $id = $faker->randomDigitNotNull;

    $sub = factory(App\Subscription::class)->create([
        'account_id' => $id,
    ]);

    $cycle = $sub->cycles()
        ->create([ 'payment_method' => 'stripe' ]);
    $cycle->activate();

    App\SubscriptionUser::create([
        'user_id' => $id,
        'subscription_id' => $sub->id,
        'role' => 'subscriber',
    ]);

    return ['id' => $id];
});

$factory->state(App\User::class, 'expired', function(Faker $faker) {

    $id = $faker->randomDigitNotNull;

    $sub = factory(App\Subscription::class)->create([
        'account_id' => $id,
    ]);

    $sub->cycles()
        ->create([
            'payment_method' => 'stripe',
            'starts_on' => Carbon::now()->subYear(),
            'ends_on' => Carbon::now()->subDay(),
        ]);

    App\SubscriptionUser::create([
        'user_id' => $id,
        'subscription_id' => $sub->id,
        'role' => 'subscriber',
    ]);

    return [ 'id' => $id ];
});
