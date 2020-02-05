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
    return view('auth/login');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('admin.home');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('users','HomeController@listUsers')->name('admin.users');
Route::get('content','ContentController@index')->name('admin.content');
Route::get('content/edit/{flag}','ContentController@edit')->name('content.edit');
Route::post('content/edit/{id}','ContentController@update')->name('content.update');

