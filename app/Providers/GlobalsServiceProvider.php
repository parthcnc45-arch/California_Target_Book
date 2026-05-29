<?php

/*
Provide App with constants
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class GlobalsServiceProvider extends ServiceProvider
{

    public function boot()
    { }

    public function register()
    { }

    // stripe counts in cents not dollars, so use this for that
    const STRIPE_MULTIPLIER = 100;

    const SUBSCRIPTION_COST_1YR = 1200 * self::STRIPE_MULTIPLIER;
    const SUBSCRIPTION_COST_2YR = 2200 * self::STRIPE_MULTIPLIER;
    const ADDON_COST = 100 * self::STRIPE_MULTIPLIER;
    // Cost per book
    // Subscribers get 3 books in even years
    //      And 2 books in odd years
    const BOOK_COST = 100 * self::STRIPE_MULTIPLIER;

    // When hard copies are shipped
    const BOOK_DELIVERIES = [
        /* (odd/even year) => [monthDelivered] */
        0 => [3, 5, 10],
        1 => [5, 11],
    ];

    /**
     * Get Price of hard copy subscription
     *  Loop through deliveries to see how many books will delivered in cycle
     *  And multiply that by the price
     *
     * @param $subLength - Length of subscription in months
     */
    public static function getBookSubscriptionPrice(int $subLength) {
        $yr = Carbon::now()->year;
        $mth = Carbon::now()->month;
        $bookCount = 0;

        for ($i = 0, $b = $yr % 2; $i < $subLength; $i++) {
            $m = $i + $mth;
            if ($m % 12 === 0 && $m !== 0) $b = ($b + 1) % 2;
            if (in_array($m % 12, self::BOOK_DELIVERIES[$b])) $bookCount++;
        }

        return $bookCount * self::BOOK_COST;
    }


}
