<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use function foo\func;

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

Route::post('login', 'AuthController@login');
Route::post('signup', 'AuthController@signup');

Route::group(['prefix' => 'password'], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

Route::group(['prefix' => 'user'], function () {
    Route::middleware('auth:api')->group(function () {
        Route::get('/', 'UserController@find');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('logout', 'AuthController@logout');

    Route::get('/articles/news', 'ArticleController@getNewsArticles');
    Route::get('/articles/news/{category_id}', 'ArticleController@getNewsArticlesByCategory');
    Route::get('/articles/clip', 'ArticleController@getClipArticles');

    Route::get('/feeds', 'FeedController@findAll');
    Route::get('/feeds/{news}', 'FeedController@find');
    Route::post('/feeds', 'FeedController@create');
});
