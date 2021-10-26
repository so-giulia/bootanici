<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('guest.home');
});

Auth::routes();


Route::middleware('auth')->namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
    Route::resource('/user', 'UserController');
    Route::resource('/portfolio', 'PortfolioController');
    Route::get('/promo/{id_promo}', 'PromoUserController@index')->name('promo.index');
    Route::post('/promo/makepayment/{id_promo}/{n_promo}', 'PromoUserController@makePayment')->name('promo.makepayment');

});

Route::get('/{any?}', 'HomeController@index')->where('any', '.*');