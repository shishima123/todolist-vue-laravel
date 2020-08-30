<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'TodoController@index')->name('todo.index');
Route::group(['namespace' => 'Api'], function () {
    Route::put('todo/tick-all', 'TodoController@tickAll')->name('todo-tick-all');
    Route::apiResource('todo', 'TodoController')->except('show');
});
Auth::routes();
