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

// Tutte le route di Laravel login
Auth::routes();

// Pubbliche
Route::get('/', 'HomeController@index')->name('home');

// Private
Route::prefix('admin')
// ->namespace('Admin') cerca il controller nella cartella admin
->namespace('Admin')
->name('admin.')
->middleware('auth')
->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('posts', 'PostController');
});
