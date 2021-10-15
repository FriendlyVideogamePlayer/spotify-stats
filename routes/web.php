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
Route::get('/authorize', 'AuthController@login')->name('login');

Route::get('/', function () {
    return view('index');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/callback', 'AuthController@callback');

Route::middleware([CheckAge::class])->group(function () {
    Route::get('/top{type}', 'DataController@getTop')->where('type', '(tracks|artists)')->name('top');

    Route::get('/recommendations', 'DataController@getRecommendations')->name('recommendations');

    Route::get('/playlists', 'DataController@getPlaylists')->name('playlists');

    Route::get('/playlist/{playlistId}', 'DataController@getPlaylistTracks')->name('playlistSelector');

    Route::get('/morelikethis', 'DataController@getCurrentTrack')->name('morelikethis');
});


