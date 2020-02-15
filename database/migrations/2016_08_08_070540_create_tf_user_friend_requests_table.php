<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserFriendRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_friend_requests', function(Blueprint $table)
		{
			$table->increments('request_id');
			$table->tinyInteger('newInfo')->default(1);
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('accept')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('tf_users')->onDelete('cascade');
			$table->integer('requestUser_id')->unsigned();
			$table->foreign('requestUser_id')->references('user_id')->on('tf_users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_friend_requests');
	}

}
