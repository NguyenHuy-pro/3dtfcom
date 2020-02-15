<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_posts', function(Blueprint $table)
		{
			$table->increments('post_id');
			$table->string('postCode',30);
			$table->text('content')->nullable();
			$table->string('image',255)->nullable();
			$table->tinyInteger('newInfo')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('created_at');
			$table->integer('viewRelation_id')->unsigned();
			$table->foreign('viewRelation_id')->references('relation_id')->on('tf_relations')->onDelete('cascade');
			$table->integer('userWallId')->unsigned();
			$table->foreign('userWallId')->references('user_id')->on('tf_users')->onDelete('cascade');
			$table->integer('userPost_id')->unsigned();
			$table->foreign('userPost_id')->references('user_id')->on('tf_users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_posts');
	}

}
