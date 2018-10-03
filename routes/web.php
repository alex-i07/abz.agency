<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});

/**
 * Routes for non-authorized user
 */

Route::get('/', 'PageController@mainPage');

Route::get('guest-fetch-roots', 'PageController@fetchRoots');

Route::get('guest-fetch-children/{id}', 'PageController@fetchChildren');

/**
 * Routes for authorized user
 */

Auth::routes();

Route::get('auth-fetch-roots', 'HomeController@fetchRoots');

Route::get('auth-fetch-children/{id}', 'HomeController@fetchChildren');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('search', 'HomeController@search');

Route::get('employee/{id}/edit', 'HomeController@getInfo')->where('id', '[0-9]+');   //405 принимает save за {id} ? Регулярку поставить или поменять местами маршруты

Route::post('employee/save', 'HomeController@editInfo');

Route::post('employee/delete', 'HomeController@deleteEmployee');


Route::get('create-form', 'HomeController@createForm');

Route::post('create', 'HomeController@createNewEmployee');
