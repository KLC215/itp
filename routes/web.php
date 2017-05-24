<?php

// Route for guest
Route::get('/', function () {
	return view('welcome');
})->middleware('guest');

// Route for authentication
Auth::routes();

// Route for get specific user
Route::get('/get-auth-user', function () {
	return Auth::user() ?: false;
});

// Route for home page after login
Route::get('/home', 'HomeController@index');

// Route for leader board page
Route::group(['prefix' => 'leaderboard'], function () {
	Route::get('/', 'LeaderBoardController@index')->name('leaderboardIndex');
	Route::get('/{filter}', 'LeaderBoardController@getUsersOrderByFilter');
});

// Route for shop page
Route::group(['prefix' => 'shop'], function () {
	Route::get('/', 'ShopController@index')->name('shopIndex');
	Route::post('/deal', 'ShopController@buyItems');
});

// Route for user profile
Route::group(['prefix' => 'profile'], function () {
	Route::get('/', 'ProfileController@index')->name('profileIndex');
	Route::get('/ac-setting', 'ProfileController@resetPasswordPage')->name('resetPassword');
	Route::get('/{slug}', 'ProfileController@browseOtherUserProfile');
	Route::post('/update-password', 'ProfileController@updatePassword')->name('updatePassword');
});

// Route for all arcades
Route::group(['middleware' => 'auth', 'prefix' => 'arcades'], function () {
	
	Route::get('/', 'ArcadeController@index')->name('arcades');
	Route::get('/{subArcade}', 'ArcadeController@subIndex');
	Route::get('/{subArcade}/{subArcadeChild}/intro', 'ArcadeController@intro');
	Route::get('/{subArcade}/{subArcadeChild}/start', 'ArcadeController@start');
	Route::get('/{subArcade}/start', 'ArcadeController@singleArcadeStart');
	
	Route::post('/complete', 'ArcadeController@complete');
	Route::post('/single-complete', 'ArcadeController@singleArcadeComplete');
	Route::post('/hint', 'ArcadeController@deductUserCoins');
	
});

// Route for all challenges
Route::group(['middleware' => 'auth', 'prefix' => 'challenges'], function () {
	
	Route::get('/', 'ChallengeController@index')->name('challenges');
	Route::get('/{challenge}/start', 'ChallengeController@start');
	
	Route::post('/complete', 'ChallengeController@complete');
	Route::post('/item-qty-subtract-1', 'ChallengeController@deductItemQty');
});