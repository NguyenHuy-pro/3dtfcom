<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfHelpContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_help_contents', function(Blueprint $table)
		{
			$table->increments('content_id');
			$table->string('name',150);
			$table->text('content');
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('helpDetail_id')->unsigned();
			$table->foreign('helpDetail_id')->references('detail_id')->on('tf_help_details')->onDelete('cascade');
			$table->integer('staff_id')->unsigned();
			$table->foreign('staff_id')->references('staff_id')->on('tf_staffs')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_help_contents');
	}

}
