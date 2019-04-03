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

// Route::get('/', function () {
//     return view('front');
// });

Route::get('/', 'FrontController@index')->name('front');
Route::get('/random_country', 'FrontController@getRandomCountry')->name('random_country');
Route::get('/check_answer', 'FrontController@checkAnswer')->name('check_answer');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
