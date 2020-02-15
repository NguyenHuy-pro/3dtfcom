<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingVisitWebsitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_visit_websites', function(Blueprint $table)
		{
			$table->increments('visit_id');
			$table->string('accessIP',30);
			$table->dateTime('dateAdded');
			$table->integer('building_id')->unsigned();
			$table->foreign('building_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_building_visit_websites');
	}

}
