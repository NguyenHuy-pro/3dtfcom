<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerCopyrightReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_copyright_reports', function(Blueprint $table)
		{
			$table->increments('report_id');
			$table->string('image',100);
			$table->string('description',500);
			$table->tinyInteger('accuracy')->default(1);
			$table->tinyInteger('confirm')->default(1);
			$table->tinyInteger('staus')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateConfirm')->nullable();
			$table->dateTime('dateAdded');
			$table->integer('bannerImage_id')->unsigned();
			$table->foreign('bannerImage_id')->references('image_id')->on('tf_banner_images')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
			$table->integer('staffConfirm_id')->unsigned()->nullable();
			$table->foreign('staffConfirm_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_banner_copyright_reports');
	}

}
