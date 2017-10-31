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



Auth::routes();

Route::get('/SearchQuery', 'SearchController@search');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/download/{filename}', 'DownloadController@download')->name('download');


Route::post('/upload', 'UploadController@upload')->name('upload');
