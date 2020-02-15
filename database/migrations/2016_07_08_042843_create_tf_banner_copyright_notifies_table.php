<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerCopyrightNotifiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_copyright_notifies', function(Blueprint $table)
		{
			$table->increments('notify_id');
			$table->string('notifyContent',200);
			$table->tinyInteger('new')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('banner_id')->unsigned();
			$table->foreign('banner_id')->references('banner_id')->on('tf_banners')->onDelete('cascade');
			$table->integer('copyrightReport_id')->unsigned();
			$table->foreign('copyrightReport_id')->references('report_id')->on('tf_banner_copyright_reports')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_banner_copyright_notifies');
	}

}
