<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfLandLicenseExpiriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_land_license_expiries', function(Blueprint $table)
		{
			$table->increments('expiry_id');
			$table->string('notifyContent',200);
			$table->tinyInteger('new')->default(1);
			$table->tinyInteger('reserve')->default(1);
			$table->tinyInteger('status')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('landLicense_id')->unsigned();
			$table->foreign('landLicense_id')->references('license_id')->on('tf_land_licenses')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_land_license_expiries');
	}

}
