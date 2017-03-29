<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('stages', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('stage_type_id');
			$table->unsignedInteger('parent_id')->nullable();
			$table->string('name');
			$table->string('display_name');
			$table->text('description');
			$table->text('image');
			$table->text('preferences')->nullable();
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('stages');
    }
}
