<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ItemsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();
		
		for ($i = 0; $i < 3; $i++) {
			$name = $faker->name;
			
			DB::table('items')->insert([
				'name'         => str_slug($name),
				'display_name' => $name,
				'description'  => $faker->sentence(10),
				'image'        => $faker->imageUrl(200, 200, 'sports'),
				'features'     => '{"cost": 2000}',
				'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
			]);
		}
	}
}
