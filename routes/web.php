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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('/stories', 'StoriesController');
Route::get('/stories/{story}/play', 'StoriesController@play')->name('stories.play');
Route::get('/stories/{story}/messages/{parent?}', 'MessagesController@index');
Route::resource('/stories/{story}/messages', 'MessagesController');

Route::group(['prefix' => '/api', 'namespace' => 'Api'], function () {
    Route::resource('/stories', 'StoriesController');
    Route::get('/stories/{story}/play', 'StoriesController@play')->name('stories.play');
    Route::get('/stories/{story}/messages/{parent?}', 'MessagesController@index');
    Route::resource('/stories/{story}/messages', 'MessagesController');
});
