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


Route::get('/admin/users', 'AdminController@usersShow')->name('adminUsers');
Route::get('/admin/folders', 'AdminController@foldersShow')->name('adminFolders');
Route::get('/admin/folders/{folder}', 'AdminController@foldersAccessShow')->name('adminFoldersAccess');
Route::get('/admin/users/{user}', 'AdminController@usersAccessShow')->name('adminUsersAccess');
Route::get('/admin/sendMessage', 'AdminController@sendMessage')->name('adminSendMessage');


Route::get('/search', 'SearchController@search')->name('search');

Route::get('/', 'HomeController@index')->name('dashboard');

Route::get('/settings', 'HomeController@settings')->name('settings');

Route::get('/folders', 'FolderController@index')->name('folders');
Route::get('/folders/{folder}', 'FolderController@show')->name('folder');
Route::get('/folders/{folder}/edit', 'FolderController@edit')->name('folderEdit');
Route::put('/folders/{folder}/edit', 'FolderController@update')->name('folderUpdate');
Route::post('/folders/{folder}/delete', 'FolderController@destroy')->name('folderDestroy');
Route::delete('/folders', 'FolderController@delete')->name('deleteFolders');
Route::delete('/files', 'FileController@delete')->name('deleteFiles');

Route::get('/folder/create', 'FolderController@create')->name('folderCreate');
Route::post('/folder/create', 'FolderController@store')->name('folderStore');

Route::get('/download/{filename}', 'DownloadController@download')->name('download');


Route::post('/upload/{folder}', 'UploadController@upload')->name('upload');

Route::get('/upload/{folder}', function ($folder) {
	if($folder == 1){
		return redirect()->route('folders');
	}else{
		return redirect()->route('folder', ['folder' => $folder]);
	}
});
