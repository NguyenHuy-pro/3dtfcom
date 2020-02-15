<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_articles', function(Blueprint $table)
		{
			$table->increments('articles_id');
			$table->string('name',200);
			$table->string('alias',255);
			$table->string('avatar',255)->nullable();
			$table->string('shortDescription',255);
			$table->string('keyWord',255)->nullable();
			$table->text('content');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('building_id')->unsigned();
			$table->foreign('building_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
			$table->integer('type_id')->unsigned();
			$table->foreign('type_id')->references('type_id')->on('tf_building_articles_types')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_building_articles');
	}

}
