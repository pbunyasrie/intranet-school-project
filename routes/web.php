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

Route::get('/search', 'SearchController@search')->name('search');

Route::get('/', 'HomeController@index')->name('dashboard');
Route::get('/folders', 'FolderController@index')->name('folders');
Route::get('/folders/{folder}', 'FolderController@show')->name('folder');

Route::get('/download/{filename}', 'DownloadController@download')->name('download');


Route::post('/upload/{folder}', 'UploadController@upload')->name('upload');

Route::get('/upload/{folder}', function ($folder) {
	if($folder == 1){
		return redirect()->route('folders');
	}else{
		return redirect()->route('folder', ['folder' => $folder]);
	}
});
