<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'APIUserController@register');
Route::post('login', 'APIUserController@login');


Route::group(['middleware' => ['jwt.verify']], function () {

    // Route::resource('user', 'APIUserController');
    Route::post('user/{id}/update', 'APIUserController@update');
    Route::get('user/profile', 'APIUserController@show');

    Route::get('store', 'APIStoreController@index');
    Route::post('store/{id}/create', 'APIStoreController@store');

    Route::get('product', 'APIProductController@index');
});