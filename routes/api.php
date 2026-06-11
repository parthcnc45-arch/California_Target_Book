<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/mail', 'ContactController@send');
Route::get('/ghl/public-subscriptions', 'Admin\GHLIntegrationController@getPublicSubscriptions');
Route::post('/ghl/subscriptions/{stripeSubId}/cancel', 'Admin\GHLIntegrationController@cancelSubscription');
Route::post('/ghl/subscriptions/{stripeSubId}/pause', 'Admin\GHLIntegrationController@pausedSubscription');

Route::group([
    'prefix' => '/feedback',
], function() {
    Route::get('/', 'FeedbackController@index');
    Route::post('/', 'FeedbackController@create');
});

Route::group([
    'prefix' => '/users/me',
    'namespace' => 'Auth',
    'middleware' => ['auth:api'],
], function() {
    Route::put('/', 'AccountController@updateProfile');
    Route::put('/password', 'AccountController@changePassword');
    Route::post('/verify-bank', 'AccountController@verifyBank');
});

Route::group([
    'prefix' => '/candidates',
    'namespace' => 'Book',
    'middleware' => ['auth:api', 'active_subscription'],
], function() {
    Route::get('/house', 'CandidatesController@showHouseCandidates');
});


/**
 * Admin level endpoints
 */
Route::group([
    'prefix' => '/users',
    'middleware' => ['auth:api', 'admin:api'],
], function() {
    Route::get('/', 'Admin\UsersController@index');
    Route::post('/', 'Admin\UsersController@create');
    Route::get('/{id}', 'Admin\UsersController@get');
    Route::put('/{id}', 'Admin\UsersController@update');
    Route::put('/{id}/password', 'Admin\UsersController@updatePassword');
});

Route::group([
    'prefix' => '/subscriptions',
    'middleware' => ['auth:api', 'admin:api'],
], function() {
    Route::get('/', 'Admin\SubscriptionsController@index');
    Route::get('/hard-copies', 'Admin\SubscriptionsController@indexHardCopies');

    Route::get('/{id}', 'Admin\SubscriptionsController@get');
    Route::post('/{id}/addons', 'Admin\SubscriptionsController@createAddon');
    Route::post('/{id}/cycles', 'Admin\SubscriptionsController@createCycle');
    Route::delete('/{id}/addons/{addonId}', 'Admin\SubscriptionsController@removeAddon');

    Route::post('/{id}/hard-copies', 'Admin\SubscriptionsController@createHardCopy');
    Route::put('/{id}/hard-copies/{bookId}', 'Admin\SubscriptionsController@updateHardCopy');
    Route::delete('/{id}/hard-copies/{bookId}', 'Admin\SubscriptionsController@removeHardCopy');
});


Route::group([
    'prefix' => '/cycles',
    'middleware' => ['auth:api', 'admin:api'],
], function() {
    Route::put('/{id}', 'Admin\CyclesController@update');
    Route::put('/{id}/markPaid', 'Admin\CyclesController@payCycle');
});

Route::group([
    'prefix' => '/companies',
    'middleware' => ['auth:api', 'admin:api'],
], function() {
    Route::put('/{id}', 'Admin\CompaniesController@update');
});


Route::group([
    'prefix' => '/events',
    'middleware' => ['auth:api', 'admin:api'],
], function() {
    Route::get('/', 'Admin\EventsController@index');
    Route::get('/{event}', 'Admin\EventsController@getEvent');
    Route::put('/{eventId}/tickets/{ticketId}', 'Admin\EventsController@updateTicket');
});

Route::group([
    'prefix' => '/polls',
    'middleware' => ['auth:api', 'admin:api'],
], function() {
    Route::get('/', 'Admin\PollsController@index');
    Route::post('/', 'Admin\PollsController@create');
    Route::get('/{id}', 'Admin\PollsController@show');
    Route::get('/{id}/response-data', 'Admin\PollsController@showRespondents');
    Route::put('/{id}', 'Admin\PollsController@update');
    Route::post('/{id}/questions', 'Admin\PollsController@createQuestion');
    Route::put('/{pollId}/questions/{questionId}', 'Admin\PollsController@updateQuestion');
});

Route::post('/help-support/contact', function(\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $userEmail = auth('api')->check() ? auth('api')->user()->email : (auth()->check() ? auth()->user()->email : 'guest@example.com');

    try {
        \Illuminate\Support\Facades\Mail::raw("From: {$userEmail}\n\nSubject: {$validated['subject']}\n\nMessage:\n{$validated['message']}", function ($message) use ($validated) {
            $message->to('parthcnc45@gmail.com')
                    ->subject('Support Contact: ' . $validated['subject']);
        });
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
});


