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

Route::get('open', function () { 
    return response()->json(['nice!']); //use this baby for unauthenticated testing, ensure the api is working
});
Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');
 
Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::get('products', 'ProductController@index');
    Route::post('products', 'ProductController@store');
    //Route::patch('products', 'ProductController@update');
});
