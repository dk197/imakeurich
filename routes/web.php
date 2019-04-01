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

Route::get('/profile', function () {
    return view('auth/profile');
});

Auth::routes();

Route::resource('games', 'GameController');

Route::post('/games/{game}/enter', 'GameController@enter');

Route::post('/games/random', 'GameController@setWinningPlaces');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/addB/{coins}', ['uses' =>'UserController@addToBalance']);
Route::get('/rmB/{coins}', ['uses' =>'UserController@removeFromBalance']);
