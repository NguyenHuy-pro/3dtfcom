<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfHelpDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_help_details', function(Blueprint $table)
		{
			$table->increments('detail_id');
			$table->string('name',150);
			$table->text('description');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
			$table->integer('helpObject_id')->unsigned();
			$table->foreign('helpObject_id')->references('object_id')->on('tf_help_objects')->onDelete('cascade');
			$table->integer('helpAction_id')->unsigned();
			$table->foreign('helpAction_id')->references('action_id')->on('tf_help_actions')->onDelete('cascade');
			//$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_help_details');
	}

}
