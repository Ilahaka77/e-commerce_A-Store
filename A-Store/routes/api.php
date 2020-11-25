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
    Route::post('kategori', 'APIKategoriController@store');

    Route::get('product/kategori/{id}', 'APIProductController@showKategori');
    Route::get('product/store', 'APIProductController@showStore');
    Route::post('product/tambah/{id}', 'APIProductController@tambahStok');
    Route::post('product/kurang/{id}', 'APIProductController@kurangStok');
    Route::resource('product', 'APIProductController');

    Route::get('cart', 'APICartController@index');
    Route::post('cart/create/{id}', 'APICartController@store');
    Route::put('cart/update/{id}', 'APICartController@update');
    Route::delete('cart/delete/{id}', 'APICartController@destroy');

    Route::get('beli', 'APITransactionController@beli');
    Route::get('pesanan', 'APITransactionController@pesanan');
    Route::post('chekout/{id}', 'APITransactionController@chekout');
    Route::get('bayar/{id}', 'APITransactionController@getpay');
    Route::put('bayar/{id}', 'APITransactionController@payment');
    Route::put('confirmpay/{id}', 'APITransactionController@confirmpay');
    Route::put('sending/{id}', 'APITransactionController@sending');
    Route::put('diterima/{id}', 'APITransactionController@confirmsent');
    Route::delete('chekout/{id}', 'APITransactionController@destroy');

});