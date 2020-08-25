<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'AuthController@login');

Route::get('/callback', 'AuthController@callback');

Route::get('/top{type}', 'DataController@getTop')->where('type', '(tracks|artists)');

Route::get('/recommendations', 'DataController@getRecommendations');

/*
Route::get('/toptracks', 'DataController@getTop');

Route::get('/topartists', 'DataController@getTop');

Route::get('/callbak', function () {
    return view('top');
});
