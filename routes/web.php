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
    return view('welcome');
});
Route::get('comforter', 'ComforterController@index');
Route::get('home', 'CurlController@index');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');
Route::get('home/{id}', 'CurlController@show');

Route::get('tshirt', 'TshirtController@index');
