<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// $this->call(UsersTableSeeder::class);
		 $this->call(StageTypesTableSeeder::class);
		 $this->call(StagesTableSeeder::class);
		 $this->call(LevelsTableSeeder::class);
		 $this->call(QuestionTypesTableSeeder::class);
		 $this->call(AdminMenusTableSeeder::class);
		 $this->call(BadgesTableSeeder::class);
		 $this->call(BadgeUserTableSeeder::class);
		 $this->call(UserOperationLogsTableSeeder::class);
		 $this->call(ItemsTableSeeder::class);

	}
}
