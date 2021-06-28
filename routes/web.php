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
Route::get('/contacts', 'HomeController@contacts')->name('contacts');
// La route che gestisce i file inviati tramite form dei contatti.
// Ha il metodo post e non get perché ovviamente i dati non devono essere visti
// nell'url
Route::post('/handle-new-contact', 'HomeController@handleNewContact')->name('handle-new-contact');
Route::get('/contacts-thankyou', 'HomeController@contactsThankYou')->name('contacts-thankyou');
Route::get('/blog', 'PostController@index')->name('blog');
// Passo lo slug qui, arriverò a show nel PostController publico
Route::get('/blog/{slug}', 'PostController@show')->name('blog-page');
// Route per la pagina Vue per vedere l'API stampata
Route::get('/vue-posts', 'PostController@vuePosts')->name('vue-post');

// Private
// prefix('admin') aggiunge /admin all'url di queste route 
Route::prefix('admin')
// ->namespace('Admin') cerca il controller nella cartella admin
->namespace('Admin')
// ->name('admin.') da un nome alla route, es admin.index
->name('admin.')
// ->middleware('auth') imposta il middleware su private
->middleware('auth')
// ->group raggruppa qui tutte le route con queste caratteristriche
->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Qui tutte le route con operazioni CRUD annesse 
    Route::resource('posts', 'PostController');
});
