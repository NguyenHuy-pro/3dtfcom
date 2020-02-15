<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfHelpObjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_help_objects', function(Blueprint $table)
		{
			$table->increments('object_id');
			$table->string('name',50)->unique();
			$table->tinyInteger('displayRank');
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateAdded');
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
		Schema::drop('tf_help_objects');
	}

}
