<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_posts', function(Blueprint $table)
		{
			$table->increments('post_id');
			$table->text('content')->nullable();
			$table->string('smallImage',100)->nullable();
			$table->string('fullImage',100)->nullable();
			$table->tinyInteger('newInfo')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dadeAdded');
			$table->integer('buildingPost_id')->unsigned();
			$table->foreign('buildingPost_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
			$table->integer('viewRelation_id')->unsigned();
			$table->foreign('viewRelation_id')->references('relation_id')->on('tf_relations')->onDelete('cascade');
			$table->integer('buildingIntro_id')->unsigned()->nullable();
			$table->foreign('buildingIntro_id')->references('building_id')->on('tf_buildings')->onDelete('cascade');
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
		Schema::drop('tf_building_posts');
	}

}
