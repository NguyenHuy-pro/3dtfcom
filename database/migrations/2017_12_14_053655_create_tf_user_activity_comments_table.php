<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserActivityCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_activity_comments', function(Blueprint $table)
		{
			$table->increments('comment_id');
			$table->text('content');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('activity_id')->unsigned();
			$table->foreign('activity_id')->references('activity_id')->on('tf_user_activities')->onDelete('cascade');
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
		Schema::drop('tf_user_activity_comments');
	}

}
