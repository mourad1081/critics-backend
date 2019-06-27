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

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function() {
    // Review definition
    Route::get('form-definitions/{id}', 'FormController@get');
    Route::patch('form-definitions/', 'FormController@patch');

    // Review
    Route::get('reviews/{id_form}/new', 'ReviewController@new');
    Route::get('reviews/{id_review}', 'ReviewController@get');
    Route::get('reviews', 'ReviewController@getAll');
    Route::post('reviews', 'ReviewController@save');
    Route::patch('reviews/{id_review}', function() {});
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();
