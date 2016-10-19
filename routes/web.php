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
Route::get('/', 'HomeController@index');
Route::post('/', 'HomeController@store');
Route::get('event/{id}/{slug}', ['as' => 'event', 'uses' => 'HomeController@event']);
Route::get('events', ['as' => 'events', 'uses' => 'HomeController@events']);

// Backend
Route::get('admin', ['as' => 'admin', 'uses' => 'Admin\DashboardController@index']);
Route::resource('admin/categories', 'Admin\CategoryController', ['as' => 'admin', 'except' => ['show']]);
Route::resource('admin/users', 'Admin\UserController', ['as' => 'admin', 'except' => ['show']]);
Route::resource('admin/events', 'Admin\EventController', ['as' => 'admin', 'except' => ['show']]);

// Authentication
Auth::routes();
