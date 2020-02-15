<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingBusinessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_businesses', function(Blueprint $table)
		{
			$table->integer('building_id')->unsigned();
			$table->foreign('building_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
			$table->integer('business_id')->unsigned();
			$table->foreign('business_id')->references('business_id')->on('tf_businesses')->onDelete('cascade');
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
		Schema::drop('tf_building_businesses');
	}

}
