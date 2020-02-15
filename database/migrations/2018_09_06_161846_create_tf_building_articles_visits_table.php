<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingArticlesVisitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_articles_visits', function(Blueprint $table)
		{
			$table->increments('visit_id');
			$table->string('accessIP',30);
			$table->dateTime('created_at');
			$table->integer('articles_id')->unsigned();
			$table->foreign('articles_id')->references('articles_id')->on('tf_building_articles')->onDelete('cascade');
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
		Schema::drop('tf_building_articles_visits');
	}

}
