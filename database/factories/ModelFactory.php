<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Statistic::class, function (Faker\Generator $faker) {
	return [
		'average_time_taken' => $faker->time('s'),
		'time_spent_coding'  => $faker->time('H:i:s'),
		'star_received'      => $faker->numberBetween(0, 30),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
	static $password;
	
	$name = $faker->name;
	
	return [
		'name'           => $name,
		'email'          => $faker->unique()->safeEmail,
		'password'       => $password ?: $password = bcrypt('password'),
		'avatar'         => '/storage/images/avatars/default-avatar.png',
		'exp'            => $faker->numberBetween(20, 99999),
		'coin'           => $faker->numberBetween(20, 99999),
		'slug'           => str_slug($name),
		'statistics_id'  => function () {
			return factory('App\Models\Statistic')->create()->id;
		},
		'remember_token' => str_random(10),
	];
});