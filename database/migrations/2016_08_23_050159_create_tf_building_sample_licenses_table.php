<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingSampleLicensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_sample_licenses', function(Blueprint $table)
		{
			$table->integer('buildingSample_id')->unsigned();
			$table->foreign('buildingSample_id')->references('sample_id')->on('tf_building_samples')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
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
		Schema::drop('tf_building_sample_licenses');
	}

}
