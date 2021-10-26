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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/specializations', 'Api\UserController@specializations'); 
// Route::get('/search/{spec_name}','Api\UserController@search');

//Consideriamo che c'è un errore
Route::namespace('Api')->group(function() {
    Route::get('/specializations', 'UserController@specializations')->name('index');
    Route::get('/sponsored', 'UserController@sponsored');
    Route::get('/search/{spec_name}/{checkbox}/{checkboxVote}', 'UserController@search');
    Route::get('/profile/{slug}', 'UserController@profile');

    // rotte post 
    Route::post('/lead', 'MailController@index');

    Route::post('/profile/{slug}/reviews', 'UserController@reviews');
});
