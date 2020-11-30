<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', ['title' => 'A-STORE']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('home', function () {
    return view('-home');
});

Route::group(['middleware' => ['auth']], function () {

Route::resource('users', 'UserController');
Route::resource('kategoris', 'KategoriController');
Route::resource('stores', 'StoreController');
Route::resource('products', 'ProductController');
Route::post('confirmbayar/{id}', 'PesananController@method');
Route::resource('pesanans', 'PesananController');
Route::resource('transactions', 'TransactionController');
});




