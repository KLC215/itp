<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('stages')->insert([
			'name' => 'arcades',
			'display_name' => 'Arcades',
			'stage_type_id' => 1,
			'description' => 'Improve and challenge your looping skills while unlocking the arcade map<div class="eo-32 eo-heart_eyes"></div>',
			'image' => '/storage/images/stages/arcades.png',
			'preferences' => '{"coin":"0","exp":"0"}',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('stages')->insert([
			'name' => 'challenges',
			'display_name' => 'Challenges',
			'stage_type_id' => 2,
			'description' => 'Solve exciting looping challenges<div class="eo-32 eo-sunglasses"></div>',
			'image' => '/storage/images/stages/challenges.png',
			'preferences' => '{"coin":"0","exp":"0"}',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('stages')->insert([
			'name' => 'tutorial',
			'display_name' => 'Tutorial',
			'stage_type_id' => 1,
			'parent_id' => 1,
			'description' => str_random(50),
			'image' => '/storage/images/stages/d1e28ffd81e51c4828ed2ec64c12be26.png',
			'preferences' => '{"coin":"0","exp":"0"}',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('stages')->insert([
			'name' => 'while-loop',
			'display_name' => 'While Loop',
			'stage_type_id' => 1,
			'parent_id' => 3,
			'description' => str_random(50),
			'image' => '/storage/images/stages/eaf9ecf4d577096136d60d3cbf4a8589.png',
			'preferences' => '{"coin":"300","exp":"300"}',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('stages')->insert([
			'name' => 'do-while-loop',
			'display_name' => 'Do While Loop',
			'stage_type_id' => 1,
			'parent_id' => 3,
			'description' => str_random(50),
			'image' => '/storage/images/stages/6e4329f6baf5c215e5ba2f0bad1587ef.png',
			'preferences' => '{"coin":"300","exp":"300"}',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('stages')->insert([
			'name' => 'for-loop',
			'display_name' => 'For Loop',
			'stage_type_id' => 1,
			'parent_id' => 3,
			'description' => str_random(50),
			'image' => '/storage/images/stages/7489fd565bb634dfb0b77cb2e95ed5e8.png',
			'preferences' => '{"coin":"300","exp":"300"}',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);
    }
}
