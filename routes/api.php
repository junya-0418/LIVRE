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

Route::get('/userCheck', fn() => Auth::user())->name('userCheck');

Route::get('/user/{id}', 'UserController@show')->name('user.show');

Route::get('/books', 'BookController@index')->name('books');

Route::get('/books/{id}', 'BookController@show')->name('book.show');


