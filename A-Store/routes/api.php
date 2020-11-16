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
    Route::get('user', 'APIUserController@index');
    Route::post('user/update/{id}', 'APIUserController@update');
    Route::get('user/profile', 'APIUserController@profile');
    Route::delete('users/delete', 'APIUserController@profile');

    Route::get('store', 'APIStoreController@index');
    Route::post('store/create', 'APIStoreController@store');

    Route::get('product', 'APIProductController@index');
    Route::get('product/show/{id}', 'APIProductController@show');
    Route::get('product/kategori/{id}', 'APIProductController@showKategori');
    Route::post('product/create', 'APIProductController@store');
    Route::put('product/update/{id}', 'APIProductController@update');
    Route::post('product/stok/{id}', 'APIProductController@tambahStok');

    Route::post('cart/{id}', 'APICartController@store');
});