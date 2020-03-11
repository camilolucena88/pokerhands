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

Route::get('/hands', 'HandController@index')->name('hands');

Route::post('/hands', 'HandController@create')->name('hands');

Route::get('/play', 'HandController@play')->name('round');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
