<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBannerImageVisitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_banner_image_visits', function(Blueprint $table)
		{
			$table->increments('visit_id');
			$table->string('accessIP',30);
			$table->dateTime('dateAdded');
			$table->integer('bannerImage_id')->unsigned();
			$table->foreign('bannerImage_id')->references('image_id')->on('tf_banner_images')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->nullable();
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
		Schema::drop('tf_banner_image_visits');
	}

}
