<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfHelpActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_help_actions', function(Blueprint $table)
		{
			$table->increments('action_id');
			$table->string('name',50)->unique();
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
		Schema::drop('tf_help_actions');
	}

}
