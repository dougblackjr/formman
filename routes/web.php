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

Route::view('/', 'welcome');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')
		->name('home');

// Form routes
Route::resource('form', 'FormController');

// Response routes
Route::get('response/{response}', 'ResponseController@show');
Route::post('response/{response}', 'ResponseController@archive');
Route::delete('response/{response}', 'ResponseController@delete');

// Export Form responses
Route::get('/export/{type}/{form}', 'FormController@export');

Route::post('/submit/{slug}', 'ResponseController@store');