<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingArticlesImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_articles_images', function(Blueprint $table)
		{
			$table->increments('image_id');
			$table->string('image',255);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('articles_id')->unsigned();
			$table->foreign('articles_id')->references('articles_id')->on('tf_building_articles')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_building_articles_images');
	}

}
