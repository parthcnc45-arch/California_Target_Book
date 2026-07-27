<?php

return [
    'one_year_online' => env('PRICE_ONE_YEAR_ONLINE', 1200),
    'one_year_print' => env('PRICE_ONE_YEAR_PRINT', 1500),
    'two_year_online' => env('PRICE_TWO_YEAR_ONLINE', 2200),
    'two_year_print' => env('PRICE_TWO_YEAR_PRINT', 2800),
    'deck_only' => env('PRICE_POST_ELECTION_DECK', 1000),
    'deck_presentation' => env('PRICE_POST_ELECTION_PRESENTATION', 200),
    'additional_printed_book' => env('PRICE_ADDITIONAL_PRINTED_BOOK', 300),
    'additional_seat' => env('PRICE_ADDITIONAL_SEAT', 100),
    'duration_one_year' => (int) env('DURATION_ONE_YEAR', 12),
    'duration_two_year' => (int) env('DURATION_TWO_YEAR', 24),
    'duration_trial' => (int) env('DURATION_TRIAL', 7),
    'names' => [
        'one_year_online' => env('STRIPE_PROD_NAME_ONE_YEAR_ONLINE', 'CTB Online 1-Year Subscription (Online Access Only)'),
        'one_year_print' => env('STRIPE_PROD_NAME_ONE_YEAR_PRINT', 'CTB Online 1-Year Subscription (Online Access & Print)'),
        'two_year_online' => env('STRIPE_PROD_NAME_TWO_YEAR_ONLINE', 'CTB Online 2-Year Subscription (Online Access Only)'),
        'two_year_print' => env('STRIPE_PROD_NAME_TWO_YEAR_PRINT', 'CTB Online 2-Year Subscription (Online Access & Print)'),
        'trial' => env('STRIPE_PROD_NAME_TRIAL', 'CTB Online Trial Subscription'),
        'display_one_year' => env('STRIPE_DISPLAY_NAME_ONE_YEAR', 'One-Year Subscription'),
        'display_two_year' => env('STRIPE_DISPLAY_NAME_TWO_YEAR', 'Two-Year Subscription'),
        'addon_product_name' => env('STRIPE_PROD_NAME_ADDON', 'Additional Online User'),
        'addon_description' => env('STRIPE_ADDON_DESCRIPTION', ':title Online Subscription Addon Account, for :email'),
        'deck_only' => env('STRIPE_PROD_NAME_DECK_ONLY', 'Post-Election Deck Only'),
        'deck_presentation' => env('STRIPE_PROD_NAME_DECK_PRESENTATION', 'Post-Election Presentation'),
        'additional_printed_book' => env('STRIPE_PROD_NAME_PRINTED_BOOK', 'Additional Printed Book'),
    ],
];
