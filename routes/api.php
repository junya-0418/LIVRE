<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::post('/search', 'BookController@search')->name('search');

Route::post('/store', 'BookController@store')->name('store');

Route::post('/book/{id}/comment', 'BookController@addComment')->name('comment');

Route::get('/userCheck', 'UserController@userCheck')->name('userCheck');

Route::get('/followCheck/{id}', 'UserController@followCheck')->name('followCheck');

Route::get('/wantCheck/{id}', 'BookController@wantCheck')->name('wantCheck');

Route::get('/user/{id}', 'UserController@show')->name('user.show');

Route::get('/lists/{id}', 'UserController@lists')->name('user.lists');

Route::put('/follow/{id}', 'UserController@follow')->name('follow');

Route::delete('/follow/{id}', 'UserController@unfollow')->name('unfollow');

Route::put('/want/{id}', 'BookController@want')->name('want');

Route::delete('/want/{id}', 'BookController@unwant')->name('unwant');

Route::delete('/delete/{id}', 'BookController@delete')->name('delete');

Route::get('/books', 'BookController@index')->name('index');

Route::get('/books/{id}', 'BookController@show')->name('book.show');


