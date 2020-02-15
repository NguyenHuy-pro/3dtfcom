<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsBannerImageVisitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_ads_banner_image_visits', function(Blueprint $table)
		{
			$table->increments('visit_id');
			$table->string('accessIP',30);
			$table->dateTime('created_at');
			$table->integer('image_id')->unsigned();
			$table->foreign('image_id')->references('image_id')->on('tf_ads_banner_images')->onDelete('cascade');
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
		Schema::drop('tf_ads_banner_image_visits');
	}

}
