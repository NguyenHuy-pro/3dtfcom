<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsBannerLicenseBusinessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_ads_banner_license_businesses', function(Blueprint $table)
		{
			$table->integer('license_id')->unsigned();
			$table->foreign('license_id')->references('license_id')->on('tf_ads_banner_licenses')->onDelete('cascade');
			$table->integer('business_id')->unsigned();
			$table->foreign('business_id')->references('business_id')->on('tf_businesses')->onDelete('cascade');
			$table->dateTime('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_ads_banner_license_businesses');
	}

}
