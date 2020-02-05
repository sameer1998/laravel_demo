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
Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');



Route::namespace('API')->middleware('auth:api')->group(function(){
    Route::get('product', 'ProductController@index');
    Route::post('product/detail', 'ProductController@details');
    Route::post('product/image', 'ProductController@imageFunction');

});

Route::fallback(function(){
    return response()->json([
        'status'=> 404,
        'message' => 'Page Not Found. Please,contact info@demoApp.com']);
});
