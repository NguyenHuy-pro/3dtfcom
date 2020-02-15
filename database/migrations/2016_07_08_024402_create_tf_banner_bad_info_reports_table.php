<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerBadInfoReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_bad_info_reports', function(Blueprint $table)
		{
			$table->increments('report	_id');
			$table->tinyInteger('accuracy')->default(1);
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateConfirm');
			$table->dateTime('dateAdded');
			$table->integer('bannerImage_id')->unsigned();
			$table->foreign('bannerImage_id')->references('image_id')->on('tf_banner_images')->onDelete('cascade');
			$table->integer('badInfo_id')->unsigned();
			$table->foreign('badInfo_id')->references('info_id')->on('tf_bad_infos')->onDelete('cascade');
			$table->integer('staff_id')->unsigned();
			$table->foreign('staff_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_banner_bad_info_reports');
	}

}
