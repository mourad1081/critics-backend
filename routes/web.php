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

Route::view('/{path?}', 'app');


Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {
    // Review definition
    Route::get('form-definitions/{id}', 'FormController@get');
    Route::patch('form-definitions/', 'FormController@patch');
    // Review
    Route::get('reviews/{id_form}/new', 'ReviewController@new')->name('new_review');
    Route::get('reviews/{id_review}', 'ReviewController@index')->name('review');
    Route::get('reviews', 'ReviewController@getAll');
    Route::post('reviews/{id_form}', 'ReviewController@save')->name('save-review');
    Route::get('reviews/{id_review}/delete', 'ReviewController@delete')->name('delete_review');
    Route::get('reviews/{id_review}/generate', 'ReviewController@generate')->name('generate_review');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{type_review}/home', 'HomeController@index')->name('home');


Auth::routes();
