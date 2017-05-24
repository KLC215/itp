<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BadgeUserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		for ($i = 1; $i < 10; $i++) {
			DB::table('badge_user')->insert([
				'badge_id'   => $i,
				'user_id'    => 1,
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			]);
		}
	}
}
