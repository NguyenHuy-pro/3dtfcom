<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfBuildingPostCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_building_post_comments', function(Blueprint $table)
		{
			$table->increments('comment_id');
			$table->text('content');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAddded');
			$table->integer('post_id')->unsigned();
			$table->foreign('post_id')->references('post_id')->on('tf_building_posts')->onDelete('cascade');
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
		Schema::drop('tf_building_post_comments');
	}

}
