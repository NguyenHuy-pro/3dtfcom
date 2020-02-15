<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_activities', function(Blueprint $table)
		{
			$table->increments('activity_id');
			$table->tinyInteger('showStatus')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('bannerShare_id')->unsigned()->nullable();
			$table->foreign('bannerShare_id')->references('share_id')->on('tf_banner_shares')->onDelete('cascade');
			$table->integer('bannerImage_id')->unsigned()->nullable();
			$table->foreign('bannerImage_id')->references('image_id')->on('tf_banner_images')->onDelete('cascade');
			$table->integer('landShare_id')->unsigned()->nullable();
			$table->foreign('landShare_id')->references('share_id')->on('tf_land_shares')->onDelete('cascade');
			$table->integer('building_id')->unsigned()->nullable();
			$table->foreign('building_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
			$table->integer('buildingBanner_id')->unsigned()->nullable();
			$table->foreign('buildingBanner_id')->references('banner_id')->on('tf_building_banners')->onDelete('cascade');
			$table->integer('buildingShare_id')->unsigned()->nullable();
			$table->foreign('buildingShare_id')->references('share_id')->on('tf_building_shares')->onDelete('cascade');
			$table->integer('buildingPost_id')->unsigned()->nullable();
			$table->foreign('buildingPost_id')->references('post_id')->on('tf_building_posts')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_activities');
	}

}
