<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsBannerImageReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_ads_banner_image_reports', function(Blueprint $table)
		{
			$table->increments('report_id');
			$table->dateTime('created_at');
			$table->integer('image_id')->unsigned();
			$table->foreign('image_id')->references('image_id')->on('tf_ads_banner_images')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
			$table->integer('badInfo_id')->unsigned();
			$table->foreign('badInfo_id')->references('badInfo_id')->on('tf_bad_infos')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_ads_banner_image_reports');
	}

}
