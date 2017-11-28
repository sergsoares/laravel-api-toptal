<?php

use Illuminate\Http\Request;
use App\Article;
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


Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/articles', 'ArticleController@store');
    Route::get('/articles/{article}', 'ArticleController@show');
    Route::get('/articles', 'ArticleController@index');
    Route::put('/articles/{article}', 'ArticleController@update');
    Route::delete('/articles/{article}', 'ArticleController@destroy');
});

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

