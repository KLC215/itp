<?php

Route::get('/', function () {
	return view('welcome');
})->middleware('guest');

Auth::routes();

Route::get('/get-auth-user', function () {
	return Auth::user() ?: false;
});

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth', 'prefix' => 'arcades'], function () {

	Route::get('/', 'ArcadeController@index')->name('arcades');
	Route::get('/{firstChild}', 'ArcadeController@routeFirstChild');
	Route::get('/{firstChild}/{secondChild}/{step}', 'ArcadeController@routeSecondChild');

	Route::post('/completed-stage', 'ArcadeController@completedStage');

//	Route::group(['middleware' => 'auth', 'prefix' => 'tutorial'], function () {
//
//		Route::get('/', 'ArcadeController@tutorialIndex')->name('tutorial');
//		//Route::get('/{name}', 'ArcadeController@index')->name('arcades');
//	});

});

Route::group(['middleware' => 'auth', 'prefix' => 'challenges'], function () {

	Route::get('/', 'ChallengeController@index')->name('challenges');

});