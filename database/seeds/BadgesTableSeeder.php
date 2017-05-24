<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BadgesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();
		
		for ($i = 0; $i < 20; $i++) {
			DB::table('badges')->insert([
				'stage_id'    => null,
				'image'       => $faker->imageUrl(200, 200, 'abstract'),
				'description' => $faker->sentence(10),
				'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
			]);
		}
	}
}
