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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login','Api\UserController@login');
Route::post('/register','Api\UserController@register');

Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/token', 'Api\ForgotPasswordController@verifyToken');
Route::post('password/reset', 'Api\ForgotPasswordController@reset');


Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/products', 'Api\ProductController@index');
//    Route::get('/products/search', 'Api\ProductController@search');
    Route::put('/products/{id}', 'Api\ProductController@update');
    Route::post('/products', 'Api\ProductController@store');
    Route::delete('/products/{id}', 'Api\ProductController@destroy');
    Route::post('/logout','Api\UserController@logout');
});
