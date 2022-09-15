<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

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

	
//all events
Route::post('store-multiple-image', 'App\Http\Controllers\ImageController@store');
Route::get('articles', 'App\Http\Controllers\ImageController@getAllArticles');
Route::get('article/{id}', 'App\Http\Controllers\ImageController@getArticle');
