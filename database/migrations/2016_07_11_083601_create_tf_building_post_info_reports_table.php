<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingPostInfoReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_post_info_reports', function(Blueprint $table)
		{
			$table->increments('report_id');
			$table->tinyInteger('accuracy')->default(1);
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateConfirm')->nullable();
			$table->dateTime('dateAdded');
			$table->integer('buildingPost_id')->unsigned();
			$table->foreign('buildingPost_id')->references('post_id')->on('tf_building_posts')->onDelete('cascade');
			$table->integer('badInfo_id')->unsigned();
			$table->foreign('badInfo_id')->references('info_id')->on('tf_bad_infos')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->nullable();
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
		Schema::drop('tf_building_post_info_reports');
	}

}
