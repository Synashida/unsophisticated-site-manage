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

Route::get('/', 'App\Http\Controllers\SiteController@create');
Route::post('/add/store', 'App\Http\Controllers\SiteController@addStore');
Route::get('/delete', 'App\Http\Controllers\SiteController@delete');
Route::post('/delete/exec', 'App\Http\Controllers\SiteController@deleteExec');
Route::get('/show_server_info', 'App\Http\Controllers\SiteController@showServerInfo');
