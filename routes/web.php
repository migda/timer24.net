<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

// Frontend
// guest
Route::get('/', 'HomeController@index');
Route::post('/', 'HomeController@store');
Route::get('event/{id}/{slug}', ['as' => 'event', 'uses' => 'HomeController@event']);
Route::get('events', ['as' => 'events', 'uses' => 'HomeController@events']);
Route::get('users', ['as' => 'users', 'uses' => 'UserController@index']);
Route::get('user/{id}', ['as' => 'user', 'uses' => 'UserController@show']);
//user
Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);
Route::get('profile/edit', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
Route::put('profile/edit', ['as' => 'profile.edit', 'uses' => 'ProfileController@update']);
// Backend
Route::get('admin', ['as' => 'admin', 'uses' => 'Admin\DashboardController@index']);
Route::resource('admin/categories', 'Admin\CategoryController', ['as' => 'admin', 'except' => ['show']]);
Route::resource('admin/users', 'Admin\UserController', ['as' => 'admin', 'except' => ['show']]);
Route::resource('admin/events', 'Admin\EventController', ['as' => 'admin', 'except' => ['show']]);

// Authentication
Auth::routes();
