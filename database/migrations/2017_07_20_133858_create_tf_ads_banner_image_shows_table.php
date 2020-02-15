<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfAdsBannerImageShowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_ads_banner_image_shows', function(Blueprint $table)
		{
			$table->increments('show_id');
			$table->string('showIP',30);
			$table->dateTime('created_at');
			$table->integer('image_id')->unsigned();
			$table->foreign('image_id')->references('image_id')->on('tf_ads_banner_images')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_ads_banner_image_shows');
	}

}
