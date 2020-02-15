<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectLicenseExpiriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_Project_license_expiries', function(Blueprint $table)
		{
			$table->increments('expiry_id');
			$table->string('notifyContent',200);
			$table->tinyInteger('new')->default(1);
			$table->tinyInteger('reserve')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('projectLicense_id')->unsigned();
			$table->foreign('projectLicense_id')->references('license_id')->on('tf_project_licenses')->onDelete('cascade');
			//$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tfproject_license_expiries');
	}

}
