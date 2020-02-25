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

Route::get('/', 'Auth\LoginController@getLogin');
Route::get('signup/activate/{token}', 'Api\AuthController@signupActivate');

Auth::routes(['verify' => true, 'register' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['role:admin', 'auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    Route::post('users/restore/{id}', 'UserController@restore')->name('users.restore');
    Route::delete('users/deletePermanently/{id}', 'UserController@deletePermanently')->name('users.permanent.delete');
    Route::resource('roles', 'RoleController');
    Route::post('roles/restore/{id}', 'RoleController@restore')->name('roles.restore');
    Route::delete('roles/deletePermanently/{id}', 'RoleController@deletePermanently')->name('roles.permanent.delete');
    Route::resource('status', 'StatusController');
    Route::post('status/restore/{id}', 'StatusController@restore')->name('status.restore');
    Route::delete('status/deletePermanently/{id}', 'StatusController@deletePermanently')->name('status.permanent.delete');
    Route::resource('services', 'ServiceController');
    Route::post('services/restore/{id}', 'ServiceController@restore')->name('services.restore');
    Route::delete('services/deletePermanently/{id}', 'ServiceController@deletePermanently')->name('services.permanent.delete');
    Route::resource('bookings', 'BookingController');
    Route::resource('barbers', 'BarberController');
    Route::post('barbers/restore/{id}', 'BarberController@restore')->name('barbers.restore');
    Route::delete('barbers/deletePermanently/{id}', 'BarberController@deletePermanently')->name('barbers.permanent.delete');
    Route::get('service/requests', 'RequestController@index')->name('request.index');
    Route::get('barber/requests', 'RequestController@barberIndex')->name('barber.request.index');
    Route::post('service/accept/{id}', 'RequestController@service')->name('request.accpet');
    Route::post('barber/accept/{id}', 'RequestController@barber')->name('barber.request.accpet');
    Route::delete('service/reject/{id}', 'RequestController@rejectservice')->name('request.accpet');
    Route::delete('barber/reject/{id}', 'RequestController@rejectbarber')->name('barber.request.accpet');
    Route::resource('commission', 'CommissionController');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/logout', 'Auth\LoginController@logout');
});
