<?php

use Illuminate\Http\Request;

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

