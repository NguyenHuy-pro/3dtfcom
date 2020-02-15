<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectBuildsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_builds', function(Blueprint $table)
		{
			$table->increments('build_id');
			$table->tinyInteger('buildStatus')->default(1);
			$table->dateTime('finishDate')->nullable();
			$table->tinyInteger('firstStatus')->default(0);
			$table->tinyInteger('publishStatus')->default(0);
			$table->tinyInteger('confirmPublish')->default(0);
			$table->dateTime('confirmDate')->nullable();
			$table->dateTime('openingDate')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('action')->default(1);
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
		Schema::drop('tf_project_builds');
	}

}
