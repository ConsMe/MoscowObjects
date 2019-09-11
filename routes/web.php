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

// Route::get('/home', 'HomeController@index')->name('home');

Route::post('users/{user}/restore', 'UserController@restore');
Route::post('files/upload', 'FileController@upload');
Route::get('files/checkdocs/{object}', 'FileController@checkIfObjectHasDocs');
Route::get('files/getdoc/{object}', 'FileController@getdoc');
Route::delete('files/{file}', 'FileController@destroy');
Route::get('favourites', 'FavouriteController@get');
Route::post('favourites/{object}', 'FavouriteController@add');
Route::delete('favourites/{objectId}', 'FavouriteController@remove');
Route::resource('users', 'UserController')->only([
    'index', 'update', 'destroy'
]);
Route::post('pdf/object', 'PdfController@getObject');
Route::post('pdf/list', 'PdfController@getList');
Route::post('pdf/list/check', 'PdfController@checkGetList');
Route::post('pdf/object', 'PdfController@getObject');
Route::post('pdf/object/check', 'PdfController@checkGetObject');
Route::post('changeSubscriptionStatus', 'SubscriptionController@changeSubscriptionStatus')->middleware('auth');

Route::resource('objects', 'ObjectController');

Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('/{any}', 'SpaController')->where('any', '.*');

Auth::routes();
