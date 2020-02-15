<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTfProjectVisitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tf_project_visits', function(Blueprint $table)
		{
			$table->increments('visit_id');
			$table->string('accessIP',30);
			$table->dateTime('dateAdded');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('project_id')->on('tf_projects')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->nullable();
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
		Schema::drop('tf_project_visits');
	}

}
