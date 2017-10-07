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

Route::get('/test', function () {

	$client = \Vaites\ApacheTika\Client::make('/usr/local/Cellar/tika/1.16/libexec/tika-app-1.16.jar');
	$text = $client->getText('/tmp/test.pdf');
	$metadata = $client->getMetadata('/tmp/test.pdf');

    return view('welcome', compact('text', 'metadata'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
