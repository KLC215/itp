<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$id = DB::table('admin_menu')->insertGetId([
			'parent_id' => 0,
			'order' => 2,
			'title' => 'Game',
			'icon' => 'fa-gamepad',
			'uri' => 'game',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('admin_menu')->insert([
			'parent_id' => $id,
			'order' => 0,
			'title' => 'Answers',
			'icon' => 'fa-anchor',
			'uri' => 'game/answers',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('admin_menu')->insert([
			'parent_id' => $id,
			'order' => 0,
			'title' => 'Badges',
			'icon' => 'fa-angellist',
			'uri' => 'game/badges',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('admin_menu')->insert([
			'parent_id' => $id,
			'order' => 0,
			'title' => 'Items',
			'icon' => 'fa-sitemap',
			'uri' => 'game/items',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('admin_menu')->insert([
			'parent_id' => $id,
			'order' => 0,
			'title' => 'Levels',
			'icon' => 'fa-level-up',
			'uri' => 'game/levels',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('admin_menu')->insert([
			'parent_id' => $id,
			'order' => 0,
			'title' => 'Question Types',
			'icon' => 'fa-question-circle',
			'uri' => 'game/question-types',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('admin_menu')->insert([
			'parent_id' => $id,
			'order' => 0,
			'title' => 'Questions',
			'icon' => 'fa-question',
			'uri' => 'game/questions',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('admin_menu')->insert([
			'parent_id' => $id,
			'order' => 0,
			'title' => 'Users',
			'icon' => 'fa-users',
			'uri' => 'game/users',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);

		DB::table('admin_menu')->insert([
			'parent_id' => $id,
			'order' => 0,
			'title' => 'Stages',
			'icon' => 'fa-instagram',
			'uri' => 'game/stages',
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);
    }
}
