<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_activities', function(Blueprint $table)
		{
			$table->increments('activity_id');
			$table->tinyInteger('highlight')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('building_id')->unsigned();
			$table->foreign('building_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
			$table->integer('articles_id')->unsigned()->nullable();
			$table->foreign('articles_id')->references('articles_id')->on('tf_building_articles')->onDelete('cascade');
			$table->integer('post_id')->unsigned()->nullable();
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
		Schema::drop('tf_building_activities');
	}

}
