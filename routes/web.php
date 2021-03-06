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

Route::get('/instructions', function () {
    return view('instructions');
});

Auth::routes();

Route::resource('games', 'GameController');

Route::get('/user/{id}', 'UserController@index');

Route::get('/allstatistics', 'UserController@allstatistics');

Route::post('/games/{game}/enter', 'GameController@enter');

Route::get('/games/{game}/getgamedata', 'GameController@getGameData');

Route::post('/games/random', 'GameController@setWinningPlaces');

Route::get('/coins', 'UserController@coins');

Route::post('/addBalance', 'UserController@addToBalance');

Route::post('/change/{id}', 'UserController@update');

Route::get('/editUser', 'UserController@showEditPage');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
