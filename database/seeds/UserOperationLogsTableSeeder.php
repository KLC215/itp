<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserOperationLogsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();
		
		for ($i = 0; $i < 15; $i++) {
			DB::table('user_operation_logs')->insert([
				'user_id'    => 1,
				'log'        => $faker->realText(15),
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			]);
		}
		
	}
}
