<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerLicenseExpiriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_license_expiries', function(Blueprint $table)
		{
			$table->increments('expiry_id');
			$table->string('notifyContent',200);
			$table->tinyInteger('new')->default(1);
			$table->tinyInteger('reserve')->default(1);
			$table->tinyInteger('status')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('bannerLicense_id')->unsigned();
			$table->foreign('bannerLicense_id')->references('license_id')->on('tf_banner_licenses')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_banner_license_expiries');
	}

}
