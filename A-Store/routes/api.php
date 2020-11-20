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

    Route::resource('user', 'APIUserController');
    Route::resource('store', 'APIStoreController');

    Route::get('kategori', 'APIKategoriController@index');

    Route::get('product/kategori/{id}', 'APIProductController@showKategori');
    Route::get('product/store', 'APIProductController@showStore');
    Route::post('product/tambah/{id}', 'APIProductController@tambahStok');
    Route::post('product/kurang/{id}', 'APIProductController@kurangStok');
    Route::resource('product', 'APIProductController');

    Route::post('cart/create/{id}', 'APICartController@store');
});