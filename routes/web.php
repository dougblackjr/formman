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

Route::get('/home', 'HomeController@index')
		->name('home');

// Form routes
Route::resource('form', 'FormController');

// Response routes
Route::post('submit/{slug}', 'ResponseController@store');
Route::get('response/{response}', 'ResponseController@show');
Route::post('response/{response}', 'ResponseController@show');
