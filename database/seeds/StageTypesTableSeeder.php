<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StageTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('stage_types')->insert([
			'name' => 'arcades',
			'display_name' => 'Arcades',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('stage_types')->insert([
			'name' => 'challenges',
			'display_name' => 'Challenges',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);
    }
}
