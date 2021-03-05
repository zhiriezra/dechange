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

Route::group(['prefix' => 'customer', 'middleware' => 'auth'], function() {
    
    Route::get('add-account-details','AccountController@create')->name('add.account');
    Route::post('add-account-details','AccountController@store')->name('store.account');

    Route::get('initiate-change','CurrencyChangeController@initiate')->name('initiate.currency.change');
    Route::post('confirm-change','CurrencyChangeController@confirmChange')->name('confirm.currency.change');

    Route::post('pay', 'PaymentController@redirectToGateway')->name('pay');
    Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
    Route::get('transactions','AccountController@transactions')->name('customer.transactions');

});

// Aministrator routes

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    
    Route::get('transactions','AdminController@transactions')->name('transactions');
    
});



Route::get('test-api', 'AccountController@testApi');