<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationshipsTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**************************************************************
		 *	Many to Many
		 **************************************************************/

		Schema::create('item_user', function (Blueprint $table) {
			$table->unsignedInteger('item_id');
			$table->unsignedInteger('user_id');
			$table->integer('quantity')->default(0);
			$table->primary(['item_id', 'user_id']);
			$table->timestamps();
		});

		Schema::create('badge_user', function (Blueprint $table) {
			$table->unsignedInteger('badge_id');
			$table->unsignedInteger('user_id');
			$table->primary(['badge_id', 'user_id']);
			$table->timestamps();
		});

		Schema::create('stage_user', function (Blueprint $table) {
			$table->unsignedInteger('stage_id');
			$table->unsignedInteger('user_id');
			$table->boolean('is_completed')->default(false);
			$table->text('statistics')->nullable();
			$table->integer('completed_times');
			$table->primary(['stage_id', 'user_id']);
			$table->timestamps();
		});

		/*Schema::create('question_user', function (Blueprint $table) {
			$table->unsignedInteger('question_id');
			$table->unsignedInteger('user_id');
			$table->boolean('is_completed')->default(false);
			$table->text('statistics')->nullable();
			$table->primary(['question_id', 'user_id']);
		});*/


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::dropIfExists('question_user');
		Schema::dropIfExists('stage_user');
		Schema::dropIfExists('badge_user');
		Schema::dropIfExists('item_user');
	}
}
