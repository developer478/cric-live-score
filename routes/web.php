<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {return view('welcome');});

Route::get('/', 'HomeController@index')->name('home');
Route::get('match/upcoming', 'LiveScore@upcommingMatches')->name('upcoming.matches');
Route::get('match/live-score', 'LiveScore@getLiveScore')->name('upcoming.matches');
