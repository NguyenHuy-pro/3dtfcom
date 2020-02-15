<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingRanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_ranks', function(Blueprint $table)
		{
			$table->integer('building_id')->unsigned();
			$table->foreign('building_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
			$table->integer('rank_id')->unsigned();
			$table->foreign('rank_id')->references('rank_id')->on('tf_ranks')->onDelete('cascade');
			$table->tinyInteger('action')->default(1);
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
		Schema::drop('tf_building_ranks');
	}

}
