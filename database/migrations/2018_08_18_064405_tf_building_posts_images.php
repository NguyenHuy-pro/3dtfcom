<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TfBuildingPostsImages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_posts_image', function(Blueprint $table)
		{
			$table->increments('image_id');
			$table->string('image',255);
			$table->dateTime('created_at');
			$table->integer('post_id')->unsigned();
			$table->foreign('post_id')->references('post_id')->on('tf_building_posts')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
