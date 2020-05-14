<?php

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
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/ads', 'AdController')->names([
    'index'  => 'ads.post',
    'store'  => 'ads.store',
]);

Route::get('offers', 'OfferController@index');
Route::post('offers', 'OfferController@search')->name('offers');

Route::get('offers/{id}', 'OfferController@show');

Route::post('offers/interaction', 'OfferController@interaction');

Route::post('offers/filterResults', 'OfferController@filter_results');

Route::post('offers/message', 'SendMessageController@index')->name('sendMessage');