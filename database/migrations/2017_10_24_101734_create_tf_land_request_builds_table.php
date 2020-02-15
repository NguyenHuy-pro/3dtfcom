<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfLandRequestBuildsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_land_request_builds', function(Blueprint $table)
		{
			$table->increments('request_id');
			$table->string('imageSample',200);
			$table->string('designDescription',400);
			$table->string('buildingName',50);
			$table->string('buildingDisplayName',50);
			$table->string('buildingWebsite',200);
			$table->string('buildingShortDescription',300);
			$table->text('buildingDescription',400);
			$table->integer('point');
			$table->dateTime('deliveryDate');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('type_id')->unsigned();
			$table->foreign('type_id')->references('type_id')->on('tf_business_types')->onDelete('cascade');
			$table->integer('license_id')->unsigned();
			$table->foreign('license_id')->references('license_id')->on('tf_land_licenses')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_land_request_builds');
	}

}
