<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingFollowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_follows', function(Blueprint $table)
		{
			$table->integer('building_id')->unsigned();
			$table->foreign('building_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
			$table->tinyInteger('newInfo')->default(1);
			$table->tinyInteger('status')->default(1);
			$table->dateTime('dateAdded');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_building_follows');
	}

}
