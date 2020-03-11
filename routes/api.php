<?php

use Illuminate\Http\Request;


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: *');
header("Access-Control-Allow-Headers: *");
// Authentication
Route::group(['prefix' => 'auth'], function () {
    Route::post('getlogin', 'Api\AuthController@login');
    Route::post('create/new/user', 'Api\AuthController@register');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user','Api\AuthController@user' );
        Route::post('update/user','Api\AuthController@updateuser' );
    });
});

Route::get('all/services/','Api\BarberController@allservices');

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('/detect/booking','Api\SearchController@myrequest');
    Route::post('update/status','Api\SearchController@update_state');

    // Client
    Route::group(['prefix' => 'client'], function () {
        Route::post('request/barber/','Api\BarberController@request');
        Route::post('search/barber/','Api\SearchController@getlist');
        Route::get('history','Api\HistoryController@clientHistory');
        Route::post('rate/booking','Api\RatingController@clientrating');
    });

    //barber
    Route::group(['prefix' => 'barber'], function () {
        Route::get('check/aproval/','Api\AuthController@aproval');
        Route::post('service/create/','Api\BarberController@services');
        Route::get('my/services/','Api\BarberController@myservices');
        Route::post('location','Api\LocationController@index');
        Route::get('history','Api\HistoryController@barberHistory');
        Route::get('my/rating','Api\RatingController@barberRating');
        Route::post('reject/request/{id}','Api\SearchController@reject');
        Route::post('accept/request/{id}','Api\SearchController@accept');
        Route::get('wallet','Api\WalletController@balance');
        Route::get('wallet_summery','Api\WalletController@wallet');
    });
});



