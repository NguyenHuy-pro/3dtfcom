<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfUserImageDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_user_image_details', function(Blueprint $table)
		{
			$table->integer('image_id')->unsigned();
			$table->foreign('image_id')->references('image_id')->on('tf_user_images')->onDelete('cascade');
			$table->integer('imageType_id')->unsigned();
			$table->foreign('imageType_id')->references('type_id')->on('tf_user_image_types')->onDelete('cascade');
			$table->tinyInteger('highlight')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_user_image_details');
	}

}
