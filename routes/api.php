<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Route::post('/login', 'SSO\WordpressAuthController@login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\RegisterController@register_api');
Route::post('/deleteuser', 'Auth\RegisterController@deleteuser_api');
Route::post('/updateeuser', 'Auth\RegisterController@updateeuser_api');
Route::post('/update-subscription-status', 'Auth\RegisterController@testLog');
Route::post('/ghl/subscription-webhook', 'Auth\RegisterController@ghlSubscriptionWebhook');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
