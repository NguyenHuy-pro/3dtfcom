<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingPostInfoNotifiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_post_info_notifies', function(Blueprint $table)
		{
			$table->increments('notify_id');
			$table->string('notifyContent',20);
			$table->tinyInteger('newInfo')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('buildingPost_id')->unsigned();
			$table->foreign('buildingPost_id')->references('post_id')->on('tf_building_posts')->onDelete('cascade');
			$table->integer('badInfo_id')->unsigned();
			$table->foreign('badInfo_id')->references('info_id')->on('tf_bad_infos')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_building_post_info_notifies');
	}

}
