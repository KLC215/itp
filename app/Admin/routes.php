<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
	'prefix'     => config('admin.prefix'),
	'namespace'  => Admin::controllerNamespace(),
	'middleware' => ['web', 'admin'],
], function (Router $router) {

	$router->get('/', 'HomeController@index');

	$router->group([
		'prefix' => 'game',
	], function (Router $router) {
		$router->resource('users', UsersController::class);
		$router->resource('stages', StagesController::class);
		$router->resource('badges', BadgesController::class);
		$router->resource('items', ItemsController::class);
		$router->resource('levels', LevelsController::class);
		$router->resource('questions', QuestionsController::class);
		$router->resource('question-types', QuestionTypesController::class);
		$router->resource('answers', AnswersController::class);
	});

});
