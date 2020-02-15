<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_updates', function(Blueprint $table)
		{
			$table->increments('update_id');
			$table->tinyInteger('build')->default(1);
			$table->tinyInteger('publish')->default(0);
			$table->tinyInteger('confirm')->default(0);
			$table->tinyInteger('action')->default(1);
			$table->dateTime('dateConfirm')->nullable();
			$table->dateTime('dateAdded');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_projects')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tf_project_updates');
	}

}
