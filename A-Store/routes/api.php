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
Route::get('profile', 'APIUserController@getAuthenticatedUser')->middleware('jwt.verify');


Route::group(['middleware' => ['jwt.verify']], function () {

    // Route::resource('user', 'APIUserController');
    Route::post('user/{id}/update', 'APIUserController@update');
    Route::get('profile', 'APIUserController@profile');
});