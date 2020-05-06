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

//Auth::routes();

//Route::get('/', 'BookController@index');

//Route::get('/search_form', 'BookController@showSearchForm')->name('search');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/{id}', 'UserController@show')->name('show');
    Route::middleware('auth')->group(function () {
        Route::put('/{id}/follow', 'UserController@follow')->name('follow');
        Route::delete('/{id}/follow', 'UserController@unfollow')->name('unfollow');
    });
});

Route::patch('/update/{id}', 'BookController@update')->name('update');

Route::delete('/delete/{id}', 'BookController@delete')->name('delete');

Route::get('/{any?}', fn() => view('index'))->where('any', '.+');
